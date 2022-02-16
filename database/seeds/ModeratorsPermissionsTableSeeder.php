<?php

use Illuminate\Database\Seeder;
use App\ModeratorsPermission;
use Carbon\Carbon;

class ModeratorsPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModeratorsPermission::truncate();

        $ModeratorsPermission = [
            [  'name' => 'Dashboard', 
               'url'  => 'admin',
               'slug' => 'admin',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Video Management', 
               'url'  => '#',
               'slug' => '#',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'All Videos', 
               'url'  => 'admin/videos',
               'slug' => 'admin/videos',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Add New Video', 
               'url'  => 'videos/create',
               'slug' => 'videos/create',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Manage Video Categories', 
               'url'  => 'admin/videos/categories',
               'slug' => 'admin/videos/categories',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Manage Live Videos', 
               'url'  => '#',
               'slug' => '#',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'All Live Videos', 
               'url'  => 'admin/livestream',
               'slug' => 'admin/livestream',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Add New Live Video', 
               'url'  => 'admin/livestream/create',
               'slug' => 'admin/livestream/create',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Manage Live Video Categories', 
               'url'  => 'admin/livestream/categories',
               'slug' => 'admin/livestream/categories',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Pages', 
               'url'  => '#',
               'slug' => '#',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'All Pages', 
               'url'  => 'admin/pages',
               'slug' => 'admin/pages',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Audio Management', 
               'url'  => '#',
               'slug' => '#',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Audio List', 
               'url'  => 'audios',
               'slug' => 'audios',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Add New Audio', 
               'url'  => 'audios/create',
               'slug' => 'audios/create',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Manage Audio Categories', 
               'url'  => 'audios/categories',
               'slug' => 'audios/categories',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'name' => 'Manage Albums', 
               'url'  => 'audios/albums',
               'slug' => 'audios/albums',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
        ];

        ModeratorsPermission::insert($ModeratorsPermission);
    }
}
