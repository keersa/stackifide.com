<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Helpers\WebsiteHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Resolve website parameter to Website model instance.
     */
    private function resolveWebsite($routeWebsite): \App\Models\Website
    {
        if ($routeWebsite instanceof \App\Models\Website) {
            return $routeWebsite;
        }
        
        // If it's a string (ID or slug), find the model
        return \App\Models\Website::where('id', $routeWebsite)
            ->orWhere('slug', $routeWebsite)
            ->firstOrFail();
    }

    /**
     * Check if user has permission to access this website.
     */
    private function checkWebsiteAccess($website): void
    {
        // If accessed via admin route, check ownership
        if ($website && request()->routeIs('admin.websites.*')) {
            $user = Auth::user();
            $websiteModel = $website instanceof \App\Models\Website 
                ? $website 
                : $this->resolveWebsite($website);
            
            if (!$user->isSuperAdmin() && $websiteModel->user_id !== $user->id) {
                abort(403, 'You do not have permission to access this website.');
            }
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get website from route parameter (admin context) or WebsiteHelper (website owner context)
        $routeWebsite = $request->route('website');
        
        // Resolve website to model instance
        if ($routeWebsite) {
            $website = $this->resolveWebsite($routeWebsite);
        } else {
            $website = WebsiteHelper::current();
        }
        
        $this->checkWebsiteAccess($website);
        
        // Build query
        $query = MenuItem::orderBy('category')
            ->orderBy('sort_order')
            ->where('website_id', $website->id);
        
        $menuItems = $query->get()->groupBy('category');

        // Since owner routes are removed, always use admin views
        return view('admin.websites.menu.index', [
            'menuItems' => $menuItems,
            'website' => $website,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        return view('admin.websites.menu.create', [
            'website' => $website,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_available' => ['sometimes', 'boolean'],
            'dietary_info' => ['nullable', 'array'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // Handle checkbox - if not present, set to false
        $validated['is_available'] = $request->has('is_available');

        // Handle dietary_info - ensure it's an array or null
        if (empty($validated['dietary_info']) || !is_array($validated['dietary_info'])) {
            $validated['dietary_info'] = [];
        }

        // Get website from route parameter (admin context) or WebsiteHelper (website owner context)
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        // Ensure website_id is set
        $validated['website_id'] = $website->id;

        MenuItem::create($validated);

        // Always redirect to admin route
        return redirect()->route('admin.websites.menu.index', $website)
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Upload a (client-cropped) menu image to S3.
     *
     * Expects: multipart/form-data with `image` file.
     * Returns: { path: string, url: string }
     */
    public function uploadImage(Request $request, $website): JsonResponse
    {
        $website = $this->resolveWebsite($website);
        $this->checkWebsiteAccess($website);

        // Force the S3 disk to throw exceptions for this request so we get actionable errors.
        // By default your config has `throw => false`, which can make writes just return `false`.
        config(['filesystems.disks.s3.throw' => true]);
        if (method_exists(Storage::class, 'forgetDisk')) {
            Storage::forgetDisk('s3');
        }

        $bucket = config('filesystems.disks.s3.bucket');
        if (empty($bucket)) {
            return response()->json([
                'message' => 'S3 is not configured: missing AWS_BUCKET (filesystems.disks.s3.bucket). Set AWS_BUCKET in your .env and clear config cache.',
            ], 500);
        }

        $validated = $request->validate([
            'image' => ['required', 'file', 'image', 'max:5120'], // 5MB
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $validated['image'];

        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        // Normalize common modern formats
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $extension = 'jpg';
        }

        $filename = (string) Str::uuid() . '.' . $extension;
        $path = "websites/{$website->id}/menu/{$filename}";

        try {
            // Some buckets have ACLs disabled (Bucket owner enforced). In that case, a "public" visibility
            // write can fail. We'll attempt a public write first, then retry without explicit visibility.
            $stored = Storage::disk('s3')->putFileAs(
                "websites/{$website->id}/menu",
                $file,
                $filename,
                ['visibility' => 'public']
            );

            if ($stored === false) {
                // With `throw` disabled, Flysystem can return false instead of throwing.
                return response()->json([
                    'message' => 'Upload failed (S3 write returned false). Check AWS credentials, region, bucket policy, and disk configuration.',
                    'details' => app()->environment('local')
                        ? 'S3 disk returned false even with throw enabled. Check AWS_* env values and bucket permissions.'
                        : null,
                    'bucket' => app()->environment('local') ? $bucket : null,
                    'region' => app()->environment('local') ? config('filesystems.disks.s3.region') : null,
                ], 500);
            }
        } catch (\Throwable $e) {
            $msg = $e->getMessage();

            // Common when bucket owner enforced / ACLs disabled:
            // "AccessControlListNotSupported" or "The bucket does not allow ACLs"
            if (str_contains($msg, 'AccessControlListNotSupported') || str_contains($msg, 'does not allow ACLs')) {
                try {
                    $stored = Storage::disk('s3')->putFileAs(
                        "websites/{$website->id}/menu",
                        $file,
                        $filename
                    );
                    if ($stored === false) {
                        return response()->json([
                            'message' => 'Upload failed (S3 write returned false). Check AWS credentials, region, bucket policy, and disk configuration.',
                            'details' => app()->environment('local') ? $msg : null,
                        ], 500);
                    }
                } catch (\Throwable $e2) {
                    return response()->json([
                        'message' => 'Upload failed writing to S3.',
                        'details' => app()->environment('local') ? $e2->getMessage() : null,
                        'bucket' => app()->environment('local') ? $bucket : null,
                        'region' => app()->environment('local') ? config('filesystems.disks.s3.region') : null,
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'Upload failed writing to S3.',
                    'details' => app()->environment('local') ? $msg : null,
                    'bucket' => app()->environment('local') ? $bucket : null,
                    'region' => app()->environment('local') ? config('filesystems.disks.s3.region') : null,
                ], 500);
            }
        }

        try {
            return response()->json([
                'path' => $path,
                'url' => Storage::disk('s3')->url($path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'path' => $path,
                'url' => null,
                'message' => 'Uploaded, but could not generate S3 URL.',
                'details' => app()->environment('local') ? $e->getMessage() : null,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $menu): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        // Resolve menu item - handle both model instance and ID
        $menuItem = null;
        if ($menu instanceof MenuItem) {
            $menuItem = $menu;
        } elseif ($menu instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get menu ID from route
            $segments = $request->segments();
            $menuIndex = array_search('menu', $segments);
            if ($menuIndex !== false && isset($segments[$menuIndex + 1])) {
                $menuId = $segments[$menuIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $menuId = $menu;
        }
        
        // If we have a menu ID, resolve it
        if ($menuItem === null && isset($menuId)) {
            $menuItem = MenuItem::where('id', $menuId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        return view('admin.websites.menu.show', [
            'menuItem' => $menuItem,
            'website' => $website,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $menu): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        // Resolve menu item - handle both model instance and ID
        $menuItem = null;
        if ($menu instanceof MenuItem) {
            $menuItem = $menu;
        } elseif ($menu instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get menu ID from route
            $segments = $request->segments();
            $menuIndex = array_search('menu', $segments);
            if ($menuIndex !== false && isset($segments[$menuIndex + 1])) {
                $menuId = $segments[$menuIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $menuId = $menu;
        }
        
        // If we have a menu ID, resolve it
        if ($menuItem === null && isset($menuId)) {
            $menuItem = MenuItem::where('id', $menuId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        return view('admin.websites.menu.edit', [
            'menuItem' => $menuItem,
            'website' => $website,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $menu): RedirectResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        // Resolve menu item - handle both model instance and ID
        $menuItem = null;
        if ($menu instanceof MenuItem) {
            $menuItem = $menu;
        } elseif ($menu instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get menu ID from route
            $segments = $request->segments();
            $menuIndex = array_search('menu', $segments);
            if ($menuIndex !== false && isset($segments[$menuIndex + 1])) {
                $menuId = $segments[$menuIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $menuId = $menu;
        }
        
        // If we have a menu ID, resolve it
        if ($menuItem === null && isset($menuId)) {
            $menuItem = MenuItem::where('id', $menuId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        $validated = $request->validate([
            'category' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_available' => ['sometimes', 'boolean'],
            'dietary_info' => ['nullable', 'array'],
        ]);

        // Handle checkbox - if not present, set to false
        $validated['is_available'] = $request->has('is_available');

        // Handle dietary_info - ensure it's an array or null
        if (empty($validated['dietary_info']) || !is_array($validated['dietary_info'])) {
            $validated['dietary_info'] = [];
        }

        $menuItem->update($validated);

        // Always redirect to admin route
        return redirect()->route('admin.websites.menu.index', $website)
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $menu): RedirectResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        // Resolve menu item - handle both model instance and ID
        $menuItem = null;
        if ($menu instanceof MenuItem) {
            $menuItem = $menu;
        } elseif ($menu instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get menu ID from route
            $segments = $request->segments();
            $menuIndex = array_search('menu', $segments);
            if ($menuIndex !== false && isset($segments[$menuIndex + 1])) {
                $menuId = $segments[$menuIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $menuId = $menu;
        }
        
        // If we have a menu ID, resolve it
        if ($menuItem === null && isset($menuId)) {
            $menuItem = MenuItem::where('id', $menuId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        $menuItem->delete();

        // Always redirect to admin route
        return redirect()->route('admin.websites.menu.index', $website)
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Reorder menu items.
     */
    public function reorder(Request $request): \Illuminate\Http\JsonResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:menu_items,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->items as $item) {
            MenuItem::where('id', $item['id'])
                ->where('website_id', $website->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
