<?php

use Illuminate\Database\Seeder;
use App\SignupMenu;
use Carbon\Carbon;

class SignupMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SignupMenu::truncate();

        $SignupDetails = [
            [  'username' => '1', 
                'email' => '1',
                'mobile' => '1',
                'avatar' => '1',
                'password' => '1',
                'password_confirm' => '1',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
 
        ];

        SignupMenu::insert($SignupDetails);
    }
}
