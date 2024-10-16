<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;

use Closure;

class CheckCPPLoginSession
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
        if ( $request->route()->getName() === 'producer.login' || $request->route()->getName() === "producer.verify_login") {
            return $next($request);
        }

        if (is_null(Session::get('cpp_user_id'))) {
            return redirect()->route('producer.login')->withErrors(['session' => 'Session expired !!']);
        }

        return $next($request);
    }
}