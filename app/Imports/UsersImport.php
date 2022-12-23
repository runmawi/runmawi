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


class UsersImport implements ToModel
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model( array $row )
    {
        $email_exist = User::where('email',$row[1])->first();

        if( empty($email_exist) ){

            $inputs = array(
                'role'      => $row[0],
                'email'     => $row[1],
                'password'  => Hash::make($row[1]),
                'active'    =>  1 ,
            );
    
            if(  $row[0] == "subscriber" ){
                $inputs +=  [ 'subscription_ends_at' => Carbon::now()->addDays(30)->setTimezone('UTC')->format('d-m-Y H:i:s'), ];
                $inputs +=  [ 'subscription_start'   => Carbon::now()->setTimezone('UTC')->format('d-m-Y H:i:s') , ];
            }
    
            if ( $row[0] == "admin" ){
                $inputs +=  [ 'package_ends' => Carbon::now()->addDays(30)->setTimezone('UTC')->format('d-m-Y') , ];
                $inputs +=  [ 'package'      => "Pro" , ];
                $inputs +=  [ 'plan_name'    => "pro" , ];
            }
    
            return new user( $inputs );
        }
    }
}