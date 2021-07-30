<?php

namespace App\Http\Controllers;

use App\ModeratorsPermission;
use App\ModeratorsRole;
use App\ModeratorsUser;
use App\UserAccess;

use Illuminate\Http\Request;

class UserAccessController extends Controller
{   

    public function Permission()
    {   
		return redirect()->back();
    }
}

