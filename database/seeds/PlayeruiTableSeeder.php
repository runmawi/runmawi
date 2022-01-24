<?php

use Illuminate\Database\Seeder;
use App\Playerui;
use Carbon\Carbon;

class PlayeruiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Playerui::truncate();
        $playerUi = [
            [  'show_logo' => '1', 
               'skip_intro' => '1',
               'embed_player' => '1',
               'watermark' => '1',
               'thumbnail' => '1',
               'advance_player' => '0',
               'speed_control' => '1',
               'video_card' => '1',
               'subtitle' => '1',
               'subtitle_preference' => '1',
               'font' => 'Arial',
               'size' => 'Medium',
               'font_color' => '#FFFFFF',
               'background_color' => '#336600',
               'opacity' => 'sadsas',
               'watermark_left' => '10%',
               'watermark_right' => '50%',
               'watermar_link' => null,
               'watermark_top' => '50%',
               'watermark_bottom' => '80%',
               'watermark_opacity' => '80%',
               'watermark_logo' => 'https://flicknexui.webnexs.org/public/uploads/settings/fl-logo-2.png',
               'watermar_width' => '10%',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
 
        ];

        Playerui::insert($playerUi);
    }
}
