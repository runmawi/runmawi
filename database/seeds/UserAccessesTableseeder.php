<?php

use Illuminate\Database\Seeder;
use App\UserAccess;
use Carbon\Carbon;

class UserAccessesTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserAccess::truncate();

        for ($i=0; $i < 16; $i++) { 
            $UserAccess = [
                [   'user_id' => '1', 
                    'role_id' => 3,
                    'permissions_id' => $i+1,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
            ];
    
            UserAccess::insert($UserAccess);
        }
       
    }
}
