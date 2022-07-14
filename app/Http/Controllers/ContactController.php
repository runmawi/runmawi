<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use \Redirect as Redirect;
use Theme;
use App\Contact;
use Auth;

class ContactController extends Controller
{
   
    public function index()
    {
     return Theme::view('contact-us');
    }

    public function Store(Request $request)
    {
        $this->validate($request, [
            'fullname' => ['required', 'string', 'max:255' ], 
            'email' => ['required', 'string', 'email', 'max:255' ],
            'phone_number' => ['string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255']
        ]);

        $data = $request->all();
        $image  =  (isset($data['screenshot'])) ? $data['screenshot'] : '';
        $image_path = public_path().'/uploads/contact_image/';
          
        if($image != '') {   
            if($image != ''  && $image != null){
                $file_old = $image_path.$image;
               if (file_exists($file_old)){
                unlink($file_old);
               }
           }
           //upload new file
           $file = $image;
           $data['screenshot'] =  str_replace(' ', '_', $file->getClientOriginalName());
           $file->move($image_path, $data['screenshot']);
        } else {
             $data['screenshot'] = '';
        }

        $contact = new Contact();
        $contact->fullname = $data['fullname'];
        $contact->email = $data['email'];
        $contact->phone_number = $data['phone_number'];
        $contact->subject =  $data['subject'];
        $contact->message =  $data['message'];
        $contact->screenshot = $data['screenshot'];
        $contact->user_id = Auth::user()->id;
        $contact->save();

        return Redirect::back()->with(array('message' => 'Sent Your Contact Request', 'note_type' => 'success') );

    }
  
    public function ViewRequest()
    {
        $contact = Contact::get();

        $data = array(
            'contact' => $contact,
        );
        // dd($data );
		return \View::make('admin.contact.index',$data);

    }

}
