<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Helpers\TenantHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get tenant from route parameter (admin context) or TenantHelper (tenant owner context)
        $routeTenant = $request->route('tenant');
        $tenant = $routeTenant ?? TenantHelper::current();
        
        // Build query
        $query = MenuItem::orderBy('category')
            ->orderBy('sort_order');
        
        // If tenant is provided via route (admin context), scope to that tenant
        if ($routeTenant) {
            $tenantId = $routeTenant instanceof \App\Models\Tenant ? $routeTenant->id : $routeTenant;
            $query->where('tenant_id', $tenantId);
        }
        // Otherwise, HasTenantScope will handle it automatically for tenant owner context
        
        $menuItems = $query->get()->groupBy('category');

        return view('tenant.menu.index', [
            'menuItems' => $menuItems,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        return view('tenant.menu.create', [
            'tenant' => $tenant,
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

        // Get tenant from route parameter (admin context) or TenantHelper (tenant owner context)
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        
        // Ensure tenant_id is set
        if ($tenant) {
            // If tenant is a model instance, get the ID
            if ($tenant instanceof \App\Models\Tenant) {
                $validated['tenant_id'] = $tenant->id;
            } else {
                // If it's a string (ID), use it directly
                $validated['tenant_id'] = $tenant;
            }
        }

        MenuItem::create($validated);

        // Determine which route to use based on context for redirect
        $redirectTenant = $request->route('tenant');
        if ($redirectTenant) {
            return redirect()->route('admin.tenants.menu.index', $redirectTenant)
                ->with('success', 'Menu item created successfully.');
        }

        return redirect()->route('owner.menu.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, MenuItem $menu): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        return view('tenant.menu.show', [
            'menuItem' => $menu,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, MenuItem $menu): View
    {
        $tenant = $request->route('tenant') ?? TenantHelper::current();
        return view('tenant.menu.edit', [
            'menuItem' => $menu,
            'tenant' => $tenant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menu): RedirectResponse
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

        $menu->update($validated);

        // Determine which route to use based on context
        $tenant = $request->route('tenant');
        if ($tenant) {
            return redirect()->route('admin.tenants.menu.index', $tenant)
                ->with('success', 'Menu item updated successfully.');
        }

        return redirect()->route('owner.menu.index')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menu): RedirectResponse
    {
        $menu->delete();

        // Determine which route to use based on context
        $tenant = request()->route('tenant');
        if ($tenant) {
            return redirect()->route('admin.tenants.menu.index', $tenant)
                ->with('success', 'Menu item deleted successfully.');
        }

        return redirect()->route('owner.menu.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}
