<?php

namespace App\Jobs;

use FFMpeg;
use App\Video as Video;
use Carbon\Carbon;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Setting as Setting;

class Convert4kVideoForStreaming implements ShouldQueue
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
        $setting = Setting::first();

        $video = $this->video->path;

        // New  Bitrate
        $BitrateFormat250 = (new X264('aac', 'libx264'))->setKiloBitrate(250);
        $BitrateFormat360 = (new X264('aac', 'libx264'))->setKiloBitrate(600);
        $lowBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(1000);
        $midBitrateFormat  =(new X264('aac', 'libx264'))->setKiloBitrate(2500);
        $highBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(5000);
        $ultraHighBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(12000); // 4K bitrate

        $converted_name = Convert4kVideoForStreaming::getCleanFileName($video);
       
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
            ->addFormat($ultraHighBitrateFormat, function($media) {
                $media->addFilter('scale=3840:2160'); // 4K resolution
            })
            ->addFormat($highBitrateFormat, function($media) {
                $media->addFilter('scale=1920:1080');
             })
             ->addFormat($midBitrateFormat, function($media) {
                 $media->addFilter('scale=1280:720');
              })
              ->addFormat($lowBitrateFormat, function($media) {
                 $media->addFilter('scale=896:480');
             })
             ->addFormat($BitrateFormat360, function($media) {
                 $media->addFilter('scale=640:360');
             })
             ->addFormat($BitrateFormat250, function($media) {
                 $media->addFilter('scale=420:240');
             })->save($converted_name);

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