<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Helpers\WebsiteHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
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
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        // Scope pages to the current website
        $pages = Page::where('website_id', $website->id)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.websites.pages.index', [
            'pages' => $pages,
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
        return view('admin.websites.pages.create', [
            'website' => $website,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // Handle checkbox - if not present, set to false
        $validated['is_published'] = $request->has('is_published');

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Ensure uniqueness within website
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (Page::where('slug', $validated['slug'])->where('website_id', $website->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Ensure website_id is set
        $validated['website_id'] = $website->id;
        
        Page::create($validated);

        // Always redirect to admin route
        return redirect()->route('admin.websites.pages.index', $website)
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $page): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        // Resolve page - Laravel might pass Website model instead of page ID
        $pageId = null;
        if ($page instanceof Page) {
            $pageModel = $page;
        } elseif ($page instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get page ID from route
            $segments = $request->segments();
            $pagesIndex = array_search('pages', $segments);
            if ($pagesIndex !== false && isset($segments[$pagesIndex + 1])) {
                $pageId = $segments[$pagesIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $pageId = $page;
        }
        
        // If we have a page ID, resolve it
        if ($pageId !== null) {
            $pageModel = Page::where('id', $pageId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        return view('admin.websites.pages.show', [
            'page' => $pageModel,
            'website' => $website,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $page): View
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        // Resolve page - Laravel might pass Website model instead of page ID
        // Extract page ID from route segments if needed
        $pageId = null;
        if ($page instanceof Page) {
            $pageModel = $page;
        } elseif ($page instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get page ID from route
            $segments = $request->segments();
            $pagesIndex = array_search('pages', $segments);
            if ($pagesIndex !== false && isset($segments[$pagesIndex + 1])) {
                $pageId = $segments[$pagesIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $pageId = $page;
        }
        
        // If we have a page ID, resolve it
        if ($pageId !== null) {
            $pageModel = Page::where('id', $pageId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        return view('admin.websites.pages.edit', [
            'page' => $pageModel,
            'website' => $website,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $page): RedirectResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        // Resolve page - Laravel might pass Website model instead of page ID
        $pageId = null;
        if ($page instanceof Page) {
            $pageModel = $page;
        } elseif ($page instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get page ID from route
            $segments = $request->segments();
            $pagesIndex = array_search('pages', $segments);
            if ($pagesIndex !== false && isset($segments[$pagesIndex + 1])) {
                $pageId = $segments[$pagesIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $pageId = $page;
        }
        
        // If we have a page ID, resolve it
        if ($pageId !== null) {
            $pageModel = Page::where('id', $pageId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        // Handle checkbox - if not present, set to false
        $validated['is_published'] = $request->has('is_published');

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Ensure uniqueness within website
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (Page::where('slug', $validated['slug'])->where('website_id', $website->id)->where('id', '!=', $pageModel->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $pageModel->update($validated);

        // Always redirect to admin route
        return redirect()->route('admin.websites.pages.edit', [$website, $pageModel->id])
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $page): RedirectResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);
        
        // Resolve page - Laravel might pass Website model instead of page ID
        $pageId = null;
        if ($page instanceof Page) {
            $pageModel = $page;
        } elseif ($page instanceof \App\Models\Website) {
            // If Laravel incorrectly passed Website model, get page ID from route
            $segments = $request->segments();
            $pagesIndex = array_search('pages', $segments);
            if ($pagesIndex !== false && isset($segments[$pagesIndex + 1])) {
                $pageId = $segments[$pagesIndex + 1];
            } else {
                abort(404);
            }
        } else {
            $pageId = $page;
        }
        
        // If we have a page ID, resolve it
        if ($pageId !== null) {
            $pageModel = Page::where('id', $pageId)
                ->where('website_id', $website->id)
                ->firstOrFail();
        }
        
        $pageModel->delete();

        // Always redirect to admin route
        return redirect()->route('admin.websites.pages.index', $website)
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Reorder pages.
     */
    public function reorder(Request $request): \Illuminate\Http\JsonResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:pages,id'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->items as $item) {
            Page::where('id', $item['id'])
                ->where('website_id', $website->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Upload a page content image to S3.
     * Expects: multipart/form-data with `image` file (can be client-cropped).
     * Returns: { path: string, url: string }
     */
    public function uploadImage(Request $request, $website): JsonResponse
    {
        $routeWebsite = $request->route('website');
        $website = $routeWebsite ? $this->resolveWebsite($routeWebsite) : WebsiteHelper::current();
        $this->checkWebsiteAccess($website);

        config(['filesystems.disks.s3.throw' => true]);
        if (method_exists(Storage::class, 'forgetDisk')) {
            Storage::forgetDisk('s3');
        }

        $bucket = config('filesystems.disks.s3.bucket');
        if (empty($bucket)) {
            return response()->json([
                'message' => 'S3 is not configured: missing AWS_BUCKET.',
            ], 500);
        }

        $validated = $request->validate([
            'image' => ['required', 'file', 'image', 'max:5120'],
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $validated['image'];
        $extension = strtolower($file->getClientOriginalExtension() ?: 'png');
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $extension = 'png';
        }

        $filename = 'page-content-' . (string) Str::uuid() . '.' . $extension;
        $path = "websites/{$website->id}/images/{$filename}";

        try {
            try {
                Storage::disk('s3')->putFileAs(
                    "websites/{$website->id}/images",
                    $file,
                    $filename,
                    ['visibility' => 'public']
                );
            } catch (\Throwable $e) {
                if (str_contains($e->getMessage(), 'AccessControlListNotSupported') || str_contains($e->getMessage(), 'does not allow ACLs') || str_contains($e->getMessage(), '400 Bad Request')) {
                    Storage::disk('s3')->putFileAs(
                        "websites/{$website->id}/images",
                        $file,
                        $filename
                    );
                } else {
                    throw $e;
                }
            }

            return response()->json([
                'path' => $path,
                'url' => Storage::disk('s3')->url($path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Upload failed: ' . $e->getMessage(),
                'details' => app()->environment('local') ? $e->getTraceAsString() : null,
            ], 500);
        }
    }
}
