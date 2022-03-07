<?php

namespace App\Jobs;

use FFMpeg;
use App\Video as Video;
use Carbon\Carbon;
use FFMpeg\FFMpeg\Coordinate\Dimension;
use FFMpeg\FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    public $timeout = 14400;
    /**
     * Create a new job instance.
     *
     * @param Video $video
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
        $lowBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(250);
        $midBitrateFormat  =(new X264('aac', 'libx264'))->setKiloBitrate(500);
        // $highBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(1000);

        $converted_name = ConvertVideoForStreaming::getCleanFileName($video);
       
              $disk = 'public';
              /*Low bitrate*/
              FFMpeg::fromDisk($disk)
              ->open($video)
              ->exportForHLS()
              ->toDisk('public')
              ->onProgress(function ($percentage) {
                $this->video->processed_low = $percentage; 
                $this->video->save();
            })
              ->addFormat($lowBitrateFormat, function($media) {
                $media->addFilter('scale=640:480');
            })
             ->addFormat($midBitrateFormat, function($media) {
               $media->addFilter('scale=960:720');
           })
//              ->addFormat($highBitrateFormat, function($media) {
//                $media->addFilter('scale=1920:1200');
//            })
              ->save($converted_name);


        $video_name = explode(".",$converted_name);
        $vid_name = $video_name[0];
        $this->video->update([
            'path' =>  $vid_name,
            'status' => 1
        ]);

    }
  
    private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';
    }
}