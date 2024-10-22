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
        $allowedRoutes = [
            'producer.login',
            'producer.verify_login',
            'producer.signup',
            'producer.signup_login',
            'producer.signup_otp',
            'producer.verify_signup',
        ];
        
        if (in_array($request->route()->getName(), $allowedRoutes)) {
            return $next($request);
        }        

        if (is_null(Session::get('cpp_user_id'))) {
            return redirect()->route('producer.login')->withErrors(['session' => 'Session expired !!']);
        }

        return $next($request);
    }
}