<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WebsiteImageController extends Controller
{
    /**
     * Resolve website parameter to Website model instance.
     */
    private function resolveWebsite($routeWebsite): Website
    {
        if ($routeWebsite instanceof Website) {
            return $routeWebsite;
        }

        return Website::where('id', $routeWebsite)
            ->firstOrFail();
    }

    /**
     * Check if user has permission to access this website.
     */
    private function checkWebsiteAccess($website): void
    {
        if ($website && request()->routeIs('admin.websites.*')) {
            $user = Auth::user();
            $websiteModel = $website instanceof Website
                ? $website
                : $this->resolveWebsite($website);

            if (!$user->isSuperAdmin() && $websiteModel->user_id !== $user->id) {
                abort(403, 'You do not have permission to access this website.');
            }
        }
    }

    /**
     * Display the website images management page.
     */
    public function index(Request $request, $website): View
    {
        $website = $this->resolveWebsite($website);
        $this->checkWebsiteAccess($website);

        return view('admin.websites.images.index', compact('website'));
    }

    /**
     * Upload a website logo to S3.
     */
    public function uploadLogo(Request $request, $website): JsonResponse
    {
        $website = $this->resolveWebsite($website);
        $this->checkWebsiteAccess($website);

        $type = $request->input('type', 'square'); // 'square' or 'rect'

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

        $prefix = $type === 'rect' ? 'logo-rect-' : 'logo-';
        $filename = $prefix . (string) Str::uuid() . '.' . $extension;
        $path = "websites/{$website->id}/images/{$filename}";

        try {
            // Attempt upload with public visibility first
            try {
                Storage::disk('s3')->putFileAs(
                    "websites/{$website->id}/images",
                    $file,
                    $filename,
                    ['visibility' => 'public']
                );
            } catch (\Throwable $e) {
                // If ACLs are disabled, retry without visibility
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

            // Update website logo field
            if ($type === 'rect') {
                $website->update(['logo_rect' => $path]);
            } else {
                $website->update(['logo' => $path]);
            }

            return response()->json([
                'path' => $path,
                'url' => $type === 'rect' ? $website->logo_rect_url : $website->logo_url,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Logo upload failed: ' . $e->getMessage(),
                'details' => app()->environment('local') ? $e->getTraceAsString() : null,
            ], 500);
        }
    }

    /**
     * Set the preferred logo type (square or rect).
     */
    public function setPreferredType(Request $request, $website): JsonResponse
    {
        $website = $this->resolveWebsite($website);
        $this->checkWebsiteAccess($website);

        $validated = $request->validate([
            'type' => ['required', 'in:square,rect'],
        ]);

        $settings = $website->settings ?? [];
        $settings['preferred_logo_type'] = $validated['type'];
        $website->update(['settings' => $settings]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the website logo.
     */
    public function removeLogo(Request $request, $website): JsonResponse
    {
        $website = $this->resolveWebsite($website);
        $this->checkWebsiteAccess($website);

        $type = $request->input('type', 'square');
        $column = $type === 'rect' ? 'logo_rect' : 'logo';

        if ($website->$column) {
            // "Soft delete" by removing the database reference but keeping the file in S3 for safety/history
            $website->update([$column => null]);
        }

        return response()->json(['success' => true]);
    }
}
