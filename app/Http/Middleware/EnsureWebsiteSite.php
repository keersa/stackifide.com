<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebsiteSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $website = \App\Helpers\WebsiteHelper::current();
        
        if (!$website) {
            // If we're on a subdomain that looks like a website but no website is found,
            // return a more helpful error message
            $host = $request->getHost();
            $hostWithoutPort = preg_replace('/:\d+$/', '', $host);
            
            if (str_ends_with($hostWithoutPort, '.localhost') || str_ends_with($hostWithoutPort, '.127.0.0.1')) {
                $subdomain = str_replace(['.localhost', '.127.0.0.1'], '', $hostWithoutPort);
                abort(404, "Website not found for host '{$subdomain}'. Make sure the website exists with a matching domain and has a current subscription.");
            }
            
            abort(404, 'Website not found. Make sure the website exists and has a current subscription.');
        }

        return $next($request);
    }
}
