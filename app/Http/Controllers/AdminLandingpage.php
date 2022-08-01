<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLandingpage extends Controller
{
    public function index(Request $request)
    {
       return view('admin.landing_page.index');
    }

    public function store(Request $request)
    {
        # code...
    }
}
