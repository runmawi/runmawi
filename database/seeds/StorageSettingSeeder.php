<?php

use Illuminate\Database\Seeder;
Use App\StorageSetting;
use Carbon\Carbon;

class StorageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StorageSetting::truncate();

        $data = [
            [
                'user_id' => 1,
                'site_storage' => 1,
                'aws_storage' => 0,
                'aws_access_key' => null,
                'aws_secret_key' => null,
                'aws_region' => null,
                'aws_bucket' => null,
                'aws_storage_path' => null,
                'aws_video_trailer_path' => null,
                'aws_season_trailer_path' => null,
                'aws_episode_path' => null,
                'aws_live_path' => null,
                'aws_audio_path' => null,
                'aws_transcode_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
        ];
        StorageSetting::insert($data);
    }
}
