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
use App\Jobs\Convert4kVideoForStreaming;
use App\Playerui as Playerui;
use FFMpeg\Coordinate\AspectRatio;
use Illuminate\Support\Facades\File;

class VideoCompression implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $video;
    public $timeout = 14400;

    /**
     * Create a new job instance.
     *
     * @param Video $video
     * 
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

        $disk = 'public';

    //     $video_path = storage_path('app/public/' . $video);
    //     $original_size = File::size($video_path) / 1024 / 1024; 

    //     $ffprobe = \FFMpeg\FFProbe::create();
    //     $duration = $ffprobe->format($video_path)->get('duration'); 

    //     $original_bitrate = ($original_size * 8 * 1024) / $duration; 

        $original_size = Storage::disk($disk)->size($video) / 1024 / 1024; 
        // $converted_name = 'Compressed_' . basename($video);
        $converted_name = Str::random(1).$video;

        $ffprobe = \FFMpeg\FFProbe::create();
        $duration = $ffprobe->format(Storage::disk($disk)->path($video))->get('duration');

        $original_bitrate = ($original_size * 8 * 1024) / $duration; 

        $target_bitrate = $original_bitrate / 2;

        \FFMpeg::fromDisk($disk)
            ->open($video)
            ->export()
            ->toDisk($disk)
            ->inFormat(
                (new \FFMpeg\Format\Video\X264('aac', 'libx264'))
                    ->setKiloBitrate($target_bitrate) 
                    ->setAudioKiloBitrate(128)
            )
            ->save($converted_name);

        $this->video->update([
            'path' => $converted_name,
        ]);

        Storage::disk($disk)->delete($video);


        $this->video->update([
            'path' =>  $converted_name,
        ]);

        $video = $this->video;   

        if(Enable_Site_Transcoding() == 1){
            if(Enable_4k_Conversion() == 1){
                Convert4kVideoForStreaming::dispatch($video);
            }else{
                ConvertVideoForStreaming::dispatch($video);
            }
        }
    }


}
