<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $port = $request->getPort();
        
        // Skip tenant identification for localhost/127.0.0.1 (development)
        // Check host without port first, then check with common ports
        $hostWithoutPort = preg_replace('/:\d+$/', '', $host);
        if (in_array($hostWithoutPort, ['localhost', '127.0.0.1']) || 
            in_array($host, ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000', 'localhost:8001', '127.0.0.1:8001'])) {
            // Check if there's a tenant parameter in the request (for testing)
            if ($request->has('tenant')) {
                $tenantParam = $request->get('tenant');
                $tenant = Tenant::where('slug', $tenantParam)
                    ->orWhere('domain', $tenantParam)
                    ->orWhere('subdomain', $tenantParam)
                    ->where('status', 'active')
                    ->first();
                
                if ($tenant) {
                    app()->instance('tenant', $tenant);
                    return $next($request);
                }
            }
            
            // No tenant found, continue as main site (don't bind any tenant)
            // Clear any existing tenant binding to be safe
            if (app()->bound('tenant')) {
                app()->forgetInstance('tenant');
            }
            return $next($request);
        }
        
        // Get the main domain from config (e.g., stackifide.com)
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
        
        // If this is the main domain, skip tenant identification
        if ($host === $mainDomain || str_ends_with($host, '.' . $mainDomain)) {
            // Check if it's a subdomain that might be a tenant
            $subdomain = str_replace('.' . $mainDomain, '', $host);
            
            if ($subdomain && $subdomain !== $host) {
                $tenant = Tenant::where('subdomain', $subdomain)
                    ->where('status', 'active')
                    ->first();
                
                if ($tenant) {
                    app()->instance('tenant', $tenant);
                    return $next($request);
                }
            }
            
            // Main site, no tenant
            return $next($request);
        }
        
        // This is a custom domain, look up the tenant
        $tenant = Tenant::where('domain', $host)
            ->where('status', 'active')
            ->first();
        
        if ($tenant) {
            app()->instance('tenant', $tenant);
            return $next($request);
        }
        
        // Tenant not found or inactive - could show 404 or redirect
        // For now, continue as main site
        return $next($request);
    }
}
