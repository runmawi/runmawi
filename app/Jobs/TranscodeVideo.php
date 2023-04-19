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
use App\Video as Video;
use Carbon\Carbon;
use App\Jobs\ConvertVideoForStreaming;

class TranscodeVideo implements ShouldQueue
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
        
        $video = $this->video->path;

        $output_path_rand = Str::random(3).$video;

        $watermark_path = public_path() . "/uploads/transcode/watermark.png";

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
            
        $this->video->update([
            'path' =>  $output_path_rand,
        ]);
        // $video->save($format, $output_path); 
        $video = $this->video;   
        ConvertVideoForStreaming::dispatch($video);

    }
    
}
