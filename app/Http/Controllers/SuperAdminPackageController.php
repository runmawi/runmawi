<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class SuperAdminPackageController extends Controller
{
    public function users_package()
    {
        $data = array(
                    'users' => User::where('active',1)->get(),
                    );

        return view('admin.package-date-management.index',$data);
    }

    public function users_package_update(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
