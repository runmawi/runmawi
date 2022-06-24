<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use \Redirect as Redirect;

class ClearCacheController extends Controller
{
   
    public function index()
    {
        return view('admin.cache.index');
    }

    public function clear_caches()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {

            return response()->json(['message'=>"false"]);
        }
    }

    public function clear_view_cache()
    {
        try {
            Artisan::call('view:clear');

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {

            return response()->json(['message'=>"false"]);

        }
       
    }

    public function Env_index(){

        return View('admin.env_debug.index');
    }

    public function Env_AppDebug(Request $request)
    {

        try {
            $Env_path = realpath(('.env'));

            $status = $request->status == "true" ? "true" : 'false';
            $Replace_data =array(
                'APP_DEBUG' => $status,
            );

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'APP_DEBUG') ? "APP_DEBUG=".$Replace_data['APP_DEBUG']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
           return response()->json(['message'=>"false"]);
        }
    }

}
