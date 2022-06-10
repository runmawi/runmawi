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
}
