<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Clickjacking Protection
        // $response->headers->set('X-Frame-Options', 'DENY'); 
        // $response->headers->set('Content-Security-Policy', "frame-ancestors 'none';");
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=*, microphone=(), camera=(), payment=*');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline'; object-src 'none'; base-uri 'self'; frame-src 'none'");


        return $response;
    }
}
