<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebsiteOwnerOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Must be authenticated
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard('web')->user();
        
        // Super admins can access any website
        if ($user->isSuperAdmin()) {
            // If admin is accessing via admin routes with website parameter, set that website
            if ($request->route('website')) {
                $website = \App\Models\Website::findOrFail($request->route('website'));
                app()->instance('website', $website);
            }
            return $next($request);
        }

        // Regular admins can access any website when accessing via admin routes
        if ($user->isAdmin() && $request->route('website')) {
            $website = \App\Models\Website::findOrFail($request->route('website'));
            app()->instance('website', $website);
            return $next($request);
        }

        // For website owner routes (on the website domain), check if user owns the website
        $website = \App\Helpers\WebsiteHelper::current();
        if ($website) {
            // Check if the current user owns this website
            if ($website->user_id === $user->id && ($user->isAdmin() || $user->isSuperAdmin())) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access. You must be the owner of this website or a super admin.');
    }
}
