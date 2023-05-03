<?php

namespace App\Jobs;


use FFMpeg;
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
use App\Video as Video;
use Carbon\Carbon;
use App\Jobs\ConvertVideoForStreaming;
use App\Playerui as Playerui;
use FFMpeg\Coordinate\AspectRatio;

class VideoClip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    public $timeout = 14400;

    /**
     * Create a new job instance.
     *
     * @param  string  $video
     * @param  string  $watermark
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
            $setting = Setting::first();
            $video = $this->video->path;

            $converted_name = Str::random(1).$video;

            $disk = 'public';
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'timeout'          => 0, // the timeout for the underlying process
                'ffmpeg.threads'   => 1, 
        ]);
            \FFMpeg::fromDisk($disk)
            ->open([$setting->video_clip, $video])
            ->export()
            ->concatWithoutTranscoding()
            ->save($converted_name);

 
            $this->video->update([
                'path' =>  $converted_name,
            ]);

        $video = $this->video;   

        ConvertVideoForStreaming::dispatch($video);

    }
    
}
