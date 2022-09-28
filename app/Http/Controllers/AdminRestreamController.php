<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRestreamController extends Controller
{
    public function Restream_index(Request $request)
    {
        return View('admin.Restream.index');
    }

    public function Restream_create(){

        return View('admin.Restream.create');
    }

    public function youtube_store(Request $request)
    {
        # code...
    }

   
    
}
