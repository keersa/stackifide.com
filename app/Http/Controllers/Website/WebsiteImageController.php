<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
     * Upload a website logo to the configured storage disk.
     */
    public function uploadLogo(Request $request, $website): JsonResponse
    {
        Log::info('Website logo upload request received', [
            'has_file' => $request->hasFile('image'),
            'file_size' => $request->hasFile('image') ? $request->file('image')->getSize() : null,
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
        ]);

        $website = $this->resolveWebsite($website);
        $this->checkWebsiteAccess($website);

        $type = $request->input('type', 'square'); // 'square' or 'rect'

        try {
            $validated = $request->validate([
                'image' => ['required', 'file', 'image', 'max:5120'],
            ]);
        } catch (ValidationException $e) {
            Log::warning('Website logo upload validation failed', [
                'website_id' => $website->id,
                'errors' => $e->errors(),
            ]);
            throw $e;
        }

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $validated['image'];
        $extension = strtolower($file->getClientOriginalExtension() ?: 'png');
        
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $extension = 'png';
        }

        $prefix = $type === 'rect' ? 'logo-rect-' : 'logo-';
        $filename = $prefix . (string) Str::uuid() . '.' . $extension;
        $path = "websites/{$website->id}/images/{$filename}";
        // Store under document-root uploads so the file is served directly (works on HostGator where document root is public_html, not Laravel's public/).
        $uploadsRoot = !empty($_SERVER['DOCUMENT_ROOT'])
            ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/uploads'
            : public_path('uploads');
        $uploadDir = $uploadsRoot . '/websites/' . $website->id . '/images';
        $fullPath = $uploadDir . '/' . $filename;

        try {
            Log::info('Website logo upload attempt', [
                'website_id' => $website->id,
                'upload_dir' => $uploadDir,
            ]);
            File::ensureDirectoryExists($uploadDir);
            if (!$file->move($uploadDir, $filename)) {
                Log::error('Website logo upload failed: move returned false', [
                    'website_id' => $website->id,
                    'upload_dir' => $uploadDir,
                ]);
                return response()->json([
                    'message' => 'Logo upload failed while writing to disk.',
                ], 500);
            }

            // Update website logo field (path format unchanged for compatibility)
            if ($type === 'rect') {
                $website->update(['logo_rect' => $path]);
            } else {
                $website->update(['logo' => $path]);
            }

            Log::info('Website logo upload success', [
                'website_id' => $website->id,
                'path' => $path,
                'url' => $type === 'rect' ? $website->logo_rect_url : $website->logo_url,
            ]);
            return response()->json([
                'path' => $path,
                'url' => $type === 'rect' ? $website->logo_rect_url : $website->logo_url,
            ]);
        } catch (\Throwable $e) {
            Log::error('Website logo upload failed', [
                'website_id' => $website->id,
                'message' => $e->getMessage(),
                'path' => $fullPath ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'Logo upload failed: ' . $e->getMessage(),
                'details' => config('app.debug') ? $e->getTraceAsString() : null,
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
            $path = $website->$column;
            $website->update([$column => null]);
            // Remove file from public/uploads if present
            $uploadsRoot = !empty($_SERVER['DOCUMENT_ROOT'])
                ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/uploads'
                : public_path('uploads');
            $uploadPath = $uploadsRoot . '/' . ltrim($path, '/');
            if (File::isFile($uploadPath)) {
                File::delete($uploadPath);
            }
        }

        return response()->json(['success' => true]);
    }
}
