<?php

namespace App\Http\Middleware;

use App\Models\Website;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyWebsite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If website is already bound (e.g., by routes file), skip identification
        if (app()->bound('website')) {
            return $next($request);
        }
        
        $host = $request->getHost();
        $port = $request->getPort();
        
        // Handle localhost subdomains for development (e.g., restaurant1.localhost:8000)
        $hostWithoutPort = preg_replace('/:\d+$/', '', $host);
        
        // Check if this is a localhost subdomain (e.g., restaurant1.localhost)
        if (str_ends_with($hostWithoutPort, '.localhost') || str_ends_with($hostWithoutPort, '.127.0.0.1')) {
            // Extract subdomain from localhost
            $subdomain = str_replace(['.localhost', '.127.0.0.1'], '', $hostWithoutPort);
            
            if ($subdomain && $subdomain !== $hostWithoutPort) {
                // Try to find by subdomain first, then by slug as fallback
                // Resolve website regardless of subscription so inactive sites can display with a notice
                $website = Website::where(function($query) use ($subdomain) {
                        $query->where('subdomain', $subdomain)
                              ->orWhere('slug', $subdomain);
                    })
                    ->first();
                
                if ($website) {
                    app()->instance('website', $website);
                    return $next($request);
                }
            }
        }
        
        // Handle plain localhost/127.0.0.1 (development)
        if (in_array($hostWithoutPort, ['localhost', '127.0.0.1']) || 
            in_array($host, ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000', 'localhost:8001', '127.0.0.1:8001'])) {
            // Check if there's a website parameter in the request (for testing)
            if ($request->has('website')) {
                $websiteParam = $request->get('website');
                $website = Website::where('slug', $websiteParam)
                    ->orWhere('domain', $websiteParam)
                    ->orWhere('subdomain', $websiteParam)
                    ->first();
                
                if ($website) {
                    app()->instance('website', $website);
                    return $next($request);
                }
            }
            
            // No website found, continue as main site (don't bind any website)
            // Clear any existing website binding to be safe
            if (app()->bound('website')) {
                app()->forgetInstance('website');
            }
            return $next($request);
        }
        
        // Get the main domain from config (e.g., stackifide.com)
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
        
        // If this is the main domain, skip website identification
        if ($host === $mainDomain || str_ends_with($host, '.' . $mainDomain)) {
            // Check if it's a subdomain that might be a website
            $subdomain = str_replace('.' . $mainDomain, '', $host);
            
            if ($subdomain && $subdomain !== $host) {
                // Try to find by subdomain first, then by slug as fallback
                $website = Website::where(function($query) use ($subdomain) {
                        $query->where('subdomain', $subdomain)
                              ->orWhere('slug', $subdomain);
                    })
                    ->active()
                    ->first();
                
                if ($website) {
                    app()->instance('website', $website);
                    return $next($request);
                }
            }
            
            // Main site, no website
            return $next($request);
        }
        
        // This is a custom domain, look up the website
        $website = Website::where('domain', $host)
            ->first();
        
        if ($website) {
            app()->instance('website', $website);
            return $next($request);
        }
        
        // Website not found or inactive - could show 404 or redirect
        // For now, continue as main site
        return $next($request);
    }
}
