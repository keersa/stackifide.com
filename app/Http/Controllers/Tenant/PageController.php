<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Helpers\TenantHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        $pages = Page::orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('tenant.pages.index', [
            'pages' => $pages,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        return view('tenant.pages.create', [
            'tenant' => $tenant,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
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
            // Ensure uniqueness within tenant
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (Page::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        Page::create($validated);

        // Determine which route to use based on context
        $tenant = $request->route('tenant');
        if ($tenant) {
            return redirect()->route('admin.tenants.pages.index', $tenant)
                ->with('success', 'Page created successfully.');
        }

        return redirect()->route('owner.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Page $page): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        return view('tenant.pages.show', [
            'page' => $page,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Page $page): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        return view('tenant.pages.edit', [
            'page' => $page,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
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
            // Ensure uniqueness within tenant
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (Page::where('slug', $validated['slug'])->where('id', '!=', $page->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $page->update($validated);

        // Determine which route to use based on context
        $tenant = $request->route('tenant');
        if ($tenant) {
            return redirect()->route('admin.tenants.pages.index', $tenant)
                ->with('success', 'Page updated successfully.');
        }

        return redirect()->route('owner.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        // Determine which route to use based on context
        $tenant = request()->route('tenant');
        if ($tenant) {
            return redirect()->route('admin.tenants.pages.index', $tenant)
                ->with('success', 'Page deleted successfully.');
        }

        return redirect()->route('owner.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
