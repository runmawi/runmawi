<?php

namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
use Illuminate\Http\Request;

class ModeratorsPermissionController extends Controller
{   

    public function Permission()
    {   
		return redirect()->back();
    }
}

