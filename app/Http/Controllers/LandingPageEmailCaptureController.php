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
        $request->validate([ 'email' => 'required|email',],
        [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
        ]);

        try {

            $inputs = array('email' => $request->email );
    
            LandingPageEmailCapture::create( $inputs );

            try {

                Mail::send('admin.Email.email_capture', $inputs, function($message) {
                        $message->to(AdminMail(), GetWebsiteName())->subject('New Email Capture on the Teefatv Site');
                        $message->from(AdminMail(),GetWebsiteName());
                    });
          
                
            } catch (\Throwable $th) {
                // return $th->getMessage();
            }

            return response()->json(['message' => 'Your request has been received. Nofity will get the site online']);

        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage() ]);
        }
    }
}