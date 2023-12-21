<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LandingPageEmailCapture;
use Mail;

class LandingPageEmailCaptureController extends Controller
{
    public function store(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
            ]);
    
            $inputs = ['email'=> $request->email];
    
            LandingPageEmailCapture::create($inputs);

            // try {

            //     Mail::send('admin.Email.TestingEmail', array('email' => $request->email ), 
            //     function($message) use ($data) {
            //         $message->from(AdminMail(),GetWebsiteName());
            //         $message->to($data['email'], $data['email'])->subject('New Email the Email');
            //     });
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }

            return response()->json(['message' => 'Form submitted successfully']);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage() ]);
        }
    }
}
