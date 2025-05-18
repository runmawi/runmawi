<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class OptimizeAuthPages
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
        // Skip optimization for non-auth pages
        if (!$this->isAuthPage($request)) {
            return $next($request);
        }

        // Disable session middleware for auth pages
        $this->disableSessionMiddleware($request);
        
        return $next($request);
    }

    /**
     * Check if the current request is for an authentication page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isAuthPage($request)
    {
        $path = $request->path();
        $authPaths = [
            'login', 'register', 'password/reset', 
            'password/email', 'password/reset/*', 'email/verify/*', 'logout',
            'admin/login', 'admin/password/reset', 'admin/password/email',
            'admin/verify', 'admin/verify/*', 'admin/logout'
        ];

        foreach ($authPaths as $authPath) {
            if ($path === $authPath || 
                (str_ends_with($authPath, '/*') && str_starts_with($path, rtrim($authPath, '/*')))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Disable session-related middleware for auth pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function disableSessionMiddleware($request)
    {
        // Skip session-related middleware for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return;
        }

        // Disable session middleware for auth pages
        $this->removeMiddlewareFromGroup('web', [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\Localization::class,
        ]);
    }

    /**
     * Remove middleware from a middleware group.
     *
     * @param  string  $group
     * @param  array  $middleware
     * @return void
     */
    protected function removeMiddlewareFromGroup($group, $middleware)
    {
        $router = app('router');
        $group = $router->getMiddlewareGroups()[$group] ?? [];
        
        $filtered = array_filter($group, function ($item) use ($middleware) {
            return !in_array($item, $middleware, true);
        });
        
        $router->middlewareGroup('web', array_values($filtered));
    }
}
