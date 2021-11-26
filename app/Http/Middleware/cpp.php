<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class cpp
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
    $data = Session::all();
            // return route('login')
        if(!empty($data['user'])){
         return $next($request);
        }else{
            // echo "<pre>";print_r('no'); print_r($data);exit();
      return redirect('/cpp/login')->with('message', 'Please Login');  
        }
    }
}
