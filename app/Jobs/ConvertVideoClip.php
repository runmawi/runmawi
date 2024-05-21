<?php

namespace App\Jobs;

use FFMpeg;
use App\SeriesSeason as SeriesSeason;
use Carbon\Carbon;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Setting as Setting;
use Streaming\Representation;

class ConvertVideoClip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $video;
    protected $storepath;
    protected $video_clip_name_without_ext;
    protected $video_clip_name_with_ext;

    public $timeout = 14400;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Setting $Settings,$storepath,$video_clip_name_with_ext,$video_clip_name_without_ext)
    {
        //
        $this->video = $Settings;
        $this->storepath = $storepath;
        $this->video_clip_name_with_ext = $video_clip_name_with_ext;
        $this->video_clip_name_without_ext = $video_clip_name_without_ext;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $video = $this->video->video_clip;
        $storepath = $this->storepath;
        $video_clip_name_with_ext = $this->video_clip_name_with_ext;
        $video_clip_name_without_ext = $this->video_clip_name_without_ext;

        $ffmpeg = \Streaming\FFMpeg::create();

        $video = $ffmpeg->open('storage/app/public/'.'/'.$video_clip_name_with_ext);

            $convertresolution=array();
                $r_1080p  = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);
                array_push($convertresolution,$r_1080p);
                $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
                array_push($convertresolution,$r_720p);
                $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
                array_push($convertresolution,$r_480p);
                $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
                array_push($convertresolution,$r_360p);
                $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
                array_push($convertresolution,$r_240p);
        $video->hls()
                ->x264()
                ->addRepresentations($convertresolution)
                ->save('storage/app/public/'.'/'.$video_clip_name_without_ext.'.m3u8');
        // Update the video_clip field in the Setting model
        $this->video->video_clip = $video_clip_name_without_ext.'.m3u8';
        $this->video->save();
    }

    private function getCleanFileName($filename){

        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';

    }
}
