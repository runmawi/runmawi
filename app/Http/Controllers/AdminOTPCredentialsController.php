<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminOTPCredentials;

class AdminOTPCredentialsController extends Controller
{
    public function index()
    {
        $data = array('AdminOTPCredentials' => AdminOTPCredentials::first(), );

        return view('admin.OTP.index',$data);
    }

    public function update(Request $request)
    {
        $AdminOTPCredentials = AdminOTPCredentials::first();

        if( !is_null($AdminOTPCredentials) ){
            AdminOTPCredentials::first()->update($request->all());
        }else{
            AdminOTPCredentials::create($request->all());
        }

        return redirect()->route('admin.OTP-Credentials-index');
    }
}