<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use \Redirect as Redirect;
use Theme;
use App\Contact;
use Auth;
use App\EmailTemplate;
use Mail;
use App\Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\User;
use View;

class ContactController extends Controller
{
   
    public function index()
    {
        $settings = Setting::first();

        $data = array(
            'settings' => $settings,
        );

            return Theme::view('contact-us',$data);
    }

    public function Store(Request $request)
    {
        $this->validate($request, [
            'fullname' => ['required', 'string', 'max:255' ], 
            'email' => ['required', 'string', 'email', 'max:255' ],
            'phone_number' => ['string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
            'g-recaptcha-response' => get_enable_captcha() == 1 ? 'required|captcha' : '',
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
        $screenshot_url = !empty($data['screenshot']) ? \URL::to('/public/uploads/contact_image'.'/'.$data['screenshot']) : null ;

        $contact = new Contact();
        $contact->fullname = $data['fullname'];
        $contact->email = $data['email'];
        $contact->phone_number = $data['phone_number'];
        $contact->subject =  $data['subject'];
        $contact->message =  $data['message'];
        $contact->screenshot = $data['screenshot'];
        $contact->user_id = Auth::user() ? Auth::user()->id : null ;
        $contact->save();

                    // Mail for Contact us
        try {
            
            $email_template_subject =  EmailTemplate::where('id',6)->pluck('heading')->first() ;
            $email_subject  = str_replace("{Name }", "$request->fullname", $email_template_subject);

            $datas = array(
                'email_subject' => $email_subject,
                'system_email'  => Setting::pluck('system_email')->first(), 
                'admin_contact_us_subject' => 'New Mail Notification from '. $data['fullname']  ,
            );

            \Mail::send('emails.contact_us', array(
                'username' => $data['fullname'],
                'website_name' => GetWebsiteName(),
                'originalMessage' => $data['message'],
                'screenshot_url' => $screenshot_url,
            ), 
            
            function($message) use ($data,$datas,$screenshot_url) {
                $message->from($datas['system_email'],GetWebsiteName());
                $message->to($data['email'])->subject($datas['email_subject']);

                if (!empty($data['screenshot'])) {
                    $message->attach($screenshot_url);
                }
            });

            $email_log      = 'Mail Sent Successfully from Contact us';
            $email_template = "6";
            $user_id = Auth::user() ? Auth::user()->id : null;

            Email_sent_log($user_id,$email_log,$email_template);

            $message      = 'Your contact request was successfully sent';
            $note_type    = 'Success'; 

            //Admin Contact us 

            \Mail::send('emails.contact_us_admin', array(
                'username' => $data['fullname'],
                'website_name' => GetWebsiteName(),
                'originalMessage' => $data['message'],
                'screenshot_url' => $screenshot_url,
            ), 
            
            function($message) use ($data,$datas,$screenshot_url) {
                $message->from($data['email'],GetWebsiteName());
                $message->to( AdminMail() )->subject($datas['admin_contact_us_subject']);

                if (!empty($data['screenshot'])) {
                    $message->attach($screenshot_url);
                }
            });
            
        }
        catch (\Exception $e) {

            $email_log      = $e->getMessage();
            $email_template = "6";
            $user_id = Auth::user() ? Auth::user()->id : null ;

            Email_notsent_log($user_id,$email_log,$email_template);

            $message      = 'Sorry! Your contact request was not sent';
            $note_type    = 'Reject'; 
        }

        return Redirect::back()->with(array('message' => $message, 'note_type' => $note_type) );
    }
  
    public function ViewRequest()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {

            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());

           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
            );
            return View::make('admin.expired_dashboard', $data);

        }else{   

            $contact = Contact::get();

            $data = array(
                'contact' => $contact,
            );

            return \View::make('admin.contact.index',$data);
        }
    }

}
