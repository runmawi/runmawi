<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use App\EmailTemplate;
use Auth ;
use URL;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $email_exist = User::where('email',$row['e_mail'])->first();

        if( empty($email_exist) &&  $row['e_mail'] != null && $row['role'] ){

            $inputs = array(
                'role'      => $row['role'],
                'email'     => $row['e_mail'],
                'username'  => strtok($row['e_mail'], "@"),
                'password'  => Hash::make($row['e_mail']),
                'active'    => $row['active_status'] ,
                'mobile'    => $row['phone_number'] ,
                'city'      => $row['city'] ,
                'country'   => $row['country'] ,
                'countryname' => $row['country']
            );
    
            if( $row['role'] == "subscriber" ){
                $inputs +=  [ 'subscription_ends_at' => Carbon::now()->addDays($row['subscription_ends_days'])->setTimezone('UTC')->format('d-m-Y H:i:s'), ];
                $inputs +=  [ 'subscription_start'   => Carbon::now()->setTimezone('UTC')->format('d-m-Y H:i:s') , ];
            }
    
            if ( $row['role'] == "admin" ){
                $inputs +=  [ 'package_ends' => Carbon::now()->addDays($row['package_ends_date'])->setTimezone('UTC')->format('d-m-Y') , ];
                $inputs +=  [ 'package'      => $row['package'] , ];
                $inputs +=  [ 'plan_name'    => strtolower($row['package']), ];
            }

            // Mail

            try {

                $template = EmailTemplate::where( 'id','=',41 )->first(); 
                $heading =$template->heading; 

                $Email_data = array(
                    'username'      =>  $row['e_mail'] ,
                    'website_name'  =>  GetWebsiteName(),
                    'url'           =>  URL::to('home'),
                    'useremail'     =>  $row['e_mail'] ,
                    'password'      =>  $row['e_mail'] ,
                    'Date'          =>  Carbon::now()->setTimezone('UTC')->format('d/m/Y H:i:s'),
                    'link'          =>  URL::to('password/reset'),
                );

                \Mail::send('emails.Import_users', $Email_data , function($message) use ($row,$heading) {

                    $message->from( AdminMail(),GetWebsiteName() );
                    $message->to( $row['e_mail'] , $row['e_mail'] )->subject( $heading );
                    
                });

                $email_log      = 'Mail Sent Successfully from Welcome E-Mail - Import users';
                $email_template = "41";
                $user_id        = Auth::user()->id;
    
                Email_sent_log( $user_id,$email_log,$email_template );
    
            } 
            catch (\Throwable $th) {

                $email_log      = $th->getMessage();
                $email_template = "41";
                $user_id        =  Auth::user()->id;
            
                Email_notsent_log( $user_id,$email_log,$email_template );
            }

            return new user( $inputs );
        }
    }
}