<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\TenantHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantLoginController extends Controller
{
    /**
     * Display the tenant owner login view.
     */
    public function create(): View
    {
        return view('tenant.auth.login');
    }

    /**
     * Handle an incoming tenant owner authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Try to authenticate with tenant_owner guard
        if (Auth::guard('tenant_owner')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Verify the owner belongs to the current tenant
            $tenant = TenantHelper::current();
            $owner = Auth::guard('tenant_owner')->user();

            if ($tenant && $owner->tenant_id === $tenant->id) {
                return redirect()->intended(route('owner.dashboard', absolute: false));
            }

            // If owner doesn't belong to current tenant, logout
            Auth::guard('tenant_owner')->logout();
        }

        // Also allow admins and super admins to login as tenant owner (they can access any tenant)
        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::guard('web')->user();
            
            if ($user->isAdmin() || $user->isSuperAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended(route('owner.dashboard', absolute: false));
            }
            
            Auth::guard('web')->logout();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated tenant owner session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('tenant_owner')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to tenant homepage or main site
        if (TenantHelper::isTenantSite()) {
            return redirect()->route('tenant.home');
        }

        return redirect('/');
    }
}
