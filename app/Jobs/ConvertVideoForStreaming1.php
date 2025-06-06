<?php

// namespace App\Jobs;

// use App\Video;
// use Carbon\Carbon;
// use FFMpeg;
// use FFMpeg\Coordinate\Dimension;
// use FFMpeg\Format\Video\X264;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;
// use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
// use URL;
// use File;
// use Illuminate\Support\Str;


// class ConvertVideoForStreaming implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     public $video;

//     /**
//      * Create a new job instance.
//      *
//      * @param Video $video
//      */
    

//     /**
//      * Execute the job.
//      *
//      * @return void
//      */
//     public static function handle($video,$file)
//     {
//         // print_r($file);
//         // exit();
//         // create a video format...
//         $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(250);
//         $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
//         $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);

//         $converted_name = ConvertVideoForStreaming::getCleanFileName($video);
        


//         // open the uploaded video from the right disk...
//         /*$disk = 'public';
//         FFMpeg::fromDisk($disk)
//             ->open($video)
//             ->addFilter(function ($filters) {
//                 $filters->resize(new Dimension(640, 480));
//             })
//             //->export()
//             ->toDisk('streamable_videos')
//             //->inFormat($lowBitrateFormat)
//              ->save($converted_name);
//         */
//         $paths = URL::to('/storage/app/public/');
//         $newpath = explode("https://localhost",$paths);
//         // $newpath = explode(" https://",$paths);
//         $newpaths = $newpath[1];
//         $paths = $_SERVER['DOCUMENT_ROOT'];
//         $folderpath = $paths.$newpaths;
//         $rand = Str::random(16);
//         // $newpaths = $newpath[1];

//         $newfile = explode(".mp4",$file);
//         $file_folder_name = $newfile[0];
//         //       print_r($file);
//         // exit();
   
//         $path = $rand . '.' . $video; 
// $is_dir = File::makeDirectory($folderpath.'/'.$file_folder_name, 0755, true, true);
//         $disk = 'public';
//         FFMpeg::fromDisk($disk)
//         ->open($video)
//             ->exportForHLS()
//             ->toDisk('public')
//             ->addFormat($lowBitrateFormat)
//             ->addFormat($midBitrateFormat)
//             ->addFormat($highBitrateFormat)
// //            ->onProgress(function ($percentage, $remaining, $rate) {
// //                echo "{$remaining} seconds left at rate: {$rate}";
// //            })
//             ->save($file_folder_name.'/'.$converted_name);

// //         $this->video->update([
// //             'converted_for_streaming_at' => Carbon::now(),
// //             'processed' => true,
// //             'stream_path' => $converted_name
// //         ]);
        
//          return $converted_name;
//     }

//     private static function getCleanFileName($filename){
//         return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.m3u8';
//     }
// }



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