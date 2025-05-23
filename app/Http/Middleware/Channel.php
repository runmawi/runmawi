<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Channel
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
        if(!empty($data['channel'])){
         return $next($request);
        }else{
            // echo "<pre>";print_r('no'); print_r($data);exit();
      return redirect('/channel/login')->with('message', 'Please Login');  
        }
    }
}
