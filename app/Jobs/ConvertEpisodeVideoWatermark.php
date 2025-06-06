<?php

namespace App\Jobs;


use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use App\Setting as Setting;
use App\Episode as Episode;
use Carbon\Carbon;
use App\Jobs\Convert4kEpisodeVideo;
use App\Jobs\ConvertEpisodeVideo;
use App\Playerui as Playerui;

class ConvertEpisodeVideoWatermark implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    protected $storepath;
    public $timeout = 14400;

    /**
     * Create a new job instance.
     *
     * @param  string  $video
     * @param  string  $watermark
     * @return void
     */
    public function __construct(Episode $video,$storepath)
    {
        $this->video = $video;
        $this->storepath = $storepath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $video = $this->video->path;
        $storepath = $this->storepath;

        $output_path_rand = Str::random(3).$video;

        $watermark_path = public_path() . "/uploads/transcode/watermark.png";

        $Playerui = Playerui::first();
  
        $watermark_path = public_path() . "/uploads/settings/".$Playerui->video_watermark;

        $video_path = storage_path() . "/app/public/".$video;

        $output_path = storage_path() . "/app/public/".$output_path_rand;

        $ffmpeg = \FFMpeg\FFMpeg::create();

        $video = $ffmpeg->open($video_path);


        $watermark = $ffmpeg->open($watermark_path);

        $watermark->filters()->resize(new Dimension(100, 100));

        $format = new X264('aac');

        $video->filters()
            ->watermark($watermark, [
                'position' => 'relative',
                'bottom' => 10,
                'right' => 10,
            ]);

        $video->save($format, $output_path);

        // return response()->download($output_path);
        $this->video->update([
            'path' =>  $output_path_rand,
        ]);
        $video->save($format, $output_path); 
        $video = $this->video;   
        if(Enable_4k_Conversion() == 1){
            Convert4kEpisodeVideo::dispatch($video,$storepath);
        }else{
            ConvertEpisodeVideo::dispatch($video,$storepath);
        }

    }
    
}
