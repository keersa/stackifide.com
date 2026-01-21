<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Helpers\TenantHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the form for editing tenant settings.
     */
    public function edit(): View
    {
        $tenant = TenantHelper::current();
        
        return view('tenant.settings.edit', [
            'tenant' => $tenant,
        ]);
    }

    /**
     * Update tenant settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = TenantHelper::current();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'contact_info' => ['nullable', 'array'],
            'settings' => ['nullable', 'array'],
        ]);

        $tenant->update($validated);

        return redirect()->route('owner.settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}
