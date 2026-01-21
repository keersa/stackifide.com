<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantOwnerOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow if user is admin or super admin
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->isAdmin() || $user->isSuperAdmin()) {
                // If admin is accessing via admin routes with tenant parameter, set that tenant
                if ($request->route('tenant')) {
                    $tenant = \App\Models\Tenant::findOrFail($request->route('tenant'));
                    app()->instance('tenant', $tenant);
                }
                return $next($request);
            }
        }

        // Allow if user is tenant owner for the current tenant
        if (Auth::guard('tenant_owner')->check()) {
            $tenant = \App\Helpers\TenantHelper::current();
            $owner = Auth::guard('tenant_owner')->user();
            
            if ($tenant && $owner->tenant_id === $tenant->id) {
                return $next($request);
            }
        }

        // Redirect to login if not authenticated
        if (!Auth::guard('tenant_owner')->check() && !Auth::guard('web')->check()) {
            return redirect()->route('tenant.login');
        }

        abort(403, 'Unauthorized access.');
    }
}
