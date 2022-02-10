<?php

use Illuminate\Database\Seeder;
use App\ModeratorsRole;
use Carbon\Carbon;


class ModeratorsRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModeratorsRole::truncate();

        $ModeratorsRole = [
            [  'role_name' => 'Admin', 
               'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'role_name' => 'SubAdmin', 
               'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
               'created_at' => Carbon::now(),
               'updated_at' => null,
             ],
            [  'role_name' => 'Moderators', 
               'user_permission'  => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
        ];

        ModeratorsRole::insert($ModeratorsRole);
    }
}
