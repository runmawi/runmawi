<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNetworkController extends Controller
{
    public function Network_index()
    {
        $Network = SeriesGenre::orderBy('order')->get();
          
        $data = array ( 'Network'=> $Network );

        return view('admin.genre.index',$data);

    }
}
