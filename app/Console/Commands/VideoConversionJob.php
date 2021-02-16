<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Streaming\DASH;
use Streaming\Stream;
use Streaming\Format\StreamFormat;
use Streaming\Representation;
use Streaming\FFMpeg;
use URL;
use Streaming\File;
class VideoConversionJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:dash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert MP4 to ABR';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $config = [
                'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/local/bin/ffprobe',
                'timeout'          => 3600, // The timeout for the underlying process
                'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
            ];
            //  $config = [
            //         'ffmpeg.binaries'  => 'C:\ffmpeg\bin\ffmpeg.exe',
            //         'ffprobe.binaries' => 'C:\ffmpeg\bin\ffprobe.exe',
            //         'timeout'          => 3600, // The timeout for the underlying process
            //         'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
            //     ];
        $ffmpeg = FFMpeg::create();
        $url = URL::to('/').'/public/';
            $video = $ffmpeg->open('/home/webnexs/public_html/finexs_demo/storage/app/public/swlZeP5HrQOcgxxD.mp4');
                $dash = $video->dash()
                ->x264()
                ->autoGenerateRepresentations();
                
        //$url = URL::to('/').'/public/';
            $dash->save('/home/webnexs/public_html/finexs_demo/storage/app/public/dash-stream.mpd');

        $this->info('Word of the Day sent to All Users');
        //return 0;
    }
}
