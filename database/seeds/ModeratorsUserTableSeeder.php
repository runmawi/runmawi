<?php

use Illuminate\Database\Seeder;
use App\ModeratorsUser;
use Carbon\Carbon;
use App\Deploy;


class ModeratorsUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Email = Deploy::first();

        if($Email != null){
            $email_id = $Email->Domain_name;
            $password = Hash::make($Email->password);
            $confirm_password = $Email->password;
            $package = ucwords($Email->package);
            $trail_start = $Email->trial_starts_at;
            $trail_end   = Carbon::now()->addDays(10);
            $trial_in    = 1;
        }else{
            $email_id = 'admin@admin.com';
            $password = '$2y$10$sT5qYIpaGIgEo3lyb7ydeuGkLldxsWDxycTgH0PyptO2Uaba6IyVO';
            $confirm_password = 'Webnexs123!@#';
            $package  =  'Pro';
            $trail_start = null;
            $trail_end   = null;
            $trial_in    = 0;
        }


        ModeratorsUser::truncate();

        $ModeratorsUser = [
            [   'username' => 'demo', 
                'email' => $email_id,
                'mobile_number' => '1234546789' ,
                'password' => $confirm_password,
                'hashedpassword' =>  $password,
                'confirm_password' => $confirm_password,
                'description' => 'Demo CPP User' ,
                'ccode' => '0' ,
                'status' => '1' ,
                'picture' => 'Default.png' ,
                'user_role' => '3' ,
                'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
                'activation_code' => null,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
        ];

        ModeratorsUser::insert($ModeratorsUser);
    }
}
