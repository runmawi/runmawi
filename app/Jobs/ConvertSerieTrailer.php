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

class ConvertSerieTrailer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $video;
    protected $storepath;
    protected $convertresolution;
    protected $trailer_video_name;
    protected $trailer_Video;

    public $timeout = 14400;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SeriesSeason $series,$storepath,$convertresolution,$trailer_video_name,$trailer_Video)
    {
        //
        $this->video = $series;
        $this->storepath = $storepath;
        $this->convertresolution = $convertresolution;
        $this->trailer_video_name = $trailer_video_name;
        $this->trailer_Video = $trailer_Video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $video = $this->video->trailer;
        $storepath = $this->storepath;
        $convertresolution = $this->convertresolution;
        $trailer_Video = $this->trailer_Video;
        $trailer_video_name = $this->trailer_video_name;

        $ffmpeg = \Streaming\FFMpeg::create();

        $video = $ffmpeg->open('public/uploads/season_trailer'.'/'.$trailer_Video);

            $r_144p  = (new Representation)->setKiloBitrate(95)->setResize(256, 144);
            $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
            $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
            $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
            $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
            $r_1080p = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);
                                    
        $video->hls()
                ->x264()
                ->addRepresentations($convertresolution)
                ->save('public/uploads/season_trailer'.'/'.$trailer_video_name.'.m3u8');

    }

    private function getCleanFileName($filename){

        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';

    }
}
