<?php

namespace App\Http\Middleware;

use Closure;
use Theme;
use Auth;
use App\HomeSetting;
use Illuminate\Support\Facades\Route;

class CheckAuthTheme5
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

        $Theme = HomeSetting::pluck('theme_choosen')->first();

        if( Auth::guest() && $Theme == "theme5-nemisha" && Route::currentRouteName() != 'FirstLanging' ){
            
            return redirect('login');
        }
        
        return $next($request);
    }
}
