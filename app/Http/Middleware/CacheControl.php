<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only apply to GET requests
        if (!$request->isMethod('get')) {
            return $response;
        }

        // Don't cache responses with these status codes
        if ($response->getStatusCode() >= 300) {
            return $response;
        }

        // Cache static assets for 1 year
        if ($request->is('assets/*') || $request->is('storage/*') || $request->is('themes/*')) {
            $response->header('Cache-Control', 'public, max-age=31536000, immutable');
        } 
        // Cache API responses for 5 minutes
        elseif ($request->is('api/*')) {
            $response->header('Cache-Control', 'public, max-age=300, must-revalidate');
        }
        // Don't cache HTML pages
        else {
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        return $response;
    }
}
