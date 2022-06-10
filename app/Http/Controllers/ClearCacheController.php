<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use \Redirect as Redirect;

class ClearCacheController extends Controller
{
    public function clear_cache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return Redirect::route('home')->with('status','Views Cleared!');

    }
}
