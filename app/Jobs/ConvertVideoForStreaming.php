<?php

namespace App\Jobs;

use App\Video;
use Carbon\Carbon;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @param Video $video
     */
    

    /**
     * Execute the job.
     *
     * @return void
     */
    public static function handle($video)
    {
        // create a video format...
        $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(250);
        $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
        $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);

        $converted_name = ConvertVideoForStreaming::getCleanFileName($video);
        
        
        // open the uploaded video from the right disk...
        /*$disk = 'public';
        FFMpeg::fromDisk($disk)
            ->open($video)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(640, 480));
            })
            //->export()
            ->toDisk('streamable_videos')
            //->inFormat($lowBitrateFormat)
             ->save($converted_name);
        */
        $disk = 'public';
        FFMpeg::fromDisk($disk)
        ->open($video)
            ->exportForHLS()
            ->toDisk('public')
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)
//            ->onProgress(function ($percentage, $remaining, $rate) {
//                echo "{$remaining} seconds left at rate: {$rate}";
//            })
            ->save($converted_name);

//         $this->video->update([
//             'converted_for_streaming_at' => Carbon::now(),
//             'processed' => true,
//             'stream_path' => $converted_name
//         ]);
        
         return $converted_name;
    }

    private static function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';
    }
}