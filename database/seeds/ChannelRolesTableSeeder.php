<?php

use Illuminate\Database\Seeder;
use App\ChannelRoles;
use Carbon\Carbon;

class ChannelRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChannelRoles::truncate();

        $ChannelRoles = [
            [  'role_name' => 'Admin', 
               'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'role_name' => 'SubAdmin', 
               'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19',
               'created_at' => Carbon::now(),
               'updated_at' => null,
             ],
            [  'role_name' => 'Channel Users', 
               'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
        ];

        ChannelRoles::insert($ChannelRoles);
    }
}
