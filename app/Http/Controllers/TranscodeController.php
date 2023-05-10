<?php

namespace App\Http\Controllers;

use App\Jobs\TranscodeVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use URL;
use Symfony\Component\Process\Process;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use App\Setting as Setting;
use FFMpeg\Coordinate\AspectRatio;
use FFMpeg\FFMpeg as FFMpegDriver;
use FFMpeg\Format\FormatInterface;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Media\Concat;
use FFMpeg\Coordinate\TimeCode;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TranscodeController extends Controller
{
    /**
     * Store a new podcast.
     *
     * @param  Request  $request
     * @return Response
     */

     public function mergeMp4Files()
     {

        $media1 = Media::createFromUrl('https://localhost/flicknexs/storage/app/public/i8x9acGw5oix9Fi5.mp4');
        $media2 = Media::createFromUrl('https://localhost/flicknexs/storage/app/public/M0x7U7HGYfq11mTn.mp4');

        $collection = $media1->model->addMediaCollection('videos');

        $collection->addMedia($media1->getPath())
            ->preservingOriginal()
            ->toMediaCollection();

        $collection->addMedia($media2->getPath())
            ->preservingOriginal()
            ->toMediaCollection();

        $combinedMedia = $media1->model->getFirstMedia('videos');

        $combinedUrl = $combinedMedia->getUrl();

     }
    public function mergeM3u8Files()
    {
        // https://localhost/flicknexs/public/uploads/transcode/input1.m3u8
        // https://localhost/flicknexs/public/uploads/transcode/input2.m3u8
        // $inputFiles = ['https://localhost/flicknexs/public/uploads/transcode/input1.m3u8',
        // 'https://localhost/flicknexs/public/uploads/transcode/input2.m3u8'];

        $firstM3u8 = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
        $secondM3u8 = 'https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8'; 

        // $inputFiles = [public_path() . "/uploads/transcode/input1.m3u8",
        // public_path() . "/uploads/transcode/input1.m3u8"];

        $inputFiles = [$firstM3u8, $secondM3u8];
        $outputFile = public_path() . '/uploads/transcode/output.m3u8';
        $ffmpeg = FFMpeg::create();
    
        $media = [];
        foreach ($inputFiles as $file) {
            $media[] = $ffmpeg->open($file);
        }
    
        $concatenated = $ffmpeg->concatenate($media)
                               ->saveFromNonBlockingStreams($outputFile);
    
        return response()->download($outputFile);
    }
    
     public function mergeM3u8Filesold()
{

    $firstM3u8 = public_path() . "/uploads/transcode/input1.m3u8";
    $secondM3u8 = public_path() . "/uploads/transcode/input2.m3u8";

    $inputFiles = [public_path() . "/uploads/transcode/input1.m3u8",
    public_path() . "/uploads/transcode/input1.m3u8"];
    $outputFile = public_path() . '/uploads/transcode/output.m3u8';
    $concatenate = \FFMpeg\FFMpeg::fromSources($inputFiles)
        ->concatenate()
        ->saveFromNonBlockingStreams($outputFile);
        dd($outputFile );
    
    return response()->download($outputFile);
}

    public function M3u8Test(Request $request)
    {
        $firstM3u8 = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
        $secondM3u8 = 'https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8'; 
        $firstM3u8 = public_path() . "/uploads/transcode/input1.m3u8";
        $secondM3u8 = public_path() . "/uploads/transcode/input2.m3u8";
        // dd($firstM3u8);

        $inputFile = public_path('/uploads/transcode/concat.txt');
        $outputFile = public_path('uploads/transcode/output.m3u8');
    
        // $ffmpeg = \FFMpeg\FFMpeg::create();
    
        $ffmpeg = FFMpeg::create();
        $ffprobe = FFProbe::create();
        $concat = new Concat($ffmpeg->getFFMpegDriver());
    
        $concat->setSafeMode(false);
    
        $m3u8Format = new WebM();
        $m3u8Format->setAudioCodec('copy');
        $m3u8Format->setVideoCodec('copy');
    
        $concat->fromFile($inputFile)
        ->saveToFile($outputFile, $m3u8Format);
        return response()->download($outputFile)->deleteFileAfterSend(true);
       
    }
     public function M3u8Testold(Request $request)
     {

        $url1 = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
        $url2 = 'https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8';
        $video = URL::to("/storage/app/public/" . $path);



        $video = URL::to("/storage/app/public/" . $path);
        
        $content1 = file_get_contents($url1);
        $content2 = file_get_contents($url2);
        
        $hlsParser = new HLS();
        $segments1 = $hlsParser->parse($content1)->getSegments();
        $segments2 = $hlsParser->parse($content2)->getSegments();
        
        $mergedSegments = array_merge($segments1, $segments2);
        
        $mergedPlaylist = "#EXTM3U\n";
        
        foreach ($mergedSegments as $segment) {
            $mergedPlaylist .= "#EXTINF:" . $segment->getDuration() . ",\n";
            $mergedPlaylist .= $segment->getUri() . "\n";
        }
        
        Storage::put('merged_playlist.m3u8', $mergedPlaylist);
     }

    public function index(Request $request)
    {
        // Create post here ..
        return view('Transcode.index');
    }

    public function upload(Request $request)
    {

        if($request->file){

          
            $file = $request->file;
            $rand = Str::random(16);
            $path =
                $rand . "." . $request->file->getClientOriginalExtension();
            $request->file->storeAs("public", $path);

            $original_name = $request->file->getClientOriginalName()
                ? $request->file->getClientOriginalName()
                : "";

            $video = URL::to("/storage/app/public/" . $path);
            $watermark = URL::to("/storage/app/public/watermark.png");

            // $file->move('uploads', $file->getClientOriginalName());
            TranscodeVideo::dispatch($video, $watermark);
            
            // TranscodeVideo::dispatch($video);

            echo '$file' . $file->getClientOriginalName() . '"/>';
            dd ($request->file);
            exit;
        }

    }

    public function watermark(){

        $watermark_path = URL::to("/storage/app/public/watermark.png");
        $video_path = URL::to("/storage/app/public/eA81jhw9Zhgj5Wkk.mp4");

    $ffmpeg = FFMpeg::create();
    $video = $ffmpeg->open($video_path);
    $watermark = $ffmpeg->open($watermark_path);

    $format = new X264('aac');
    // $format->setVideoDimensions(640, 360);

    $output_path = storage_path('app/public/result.mp4');
    
    $video->filters()
        ->watermark($watermark, [
            'position' => 'relative',
            'bottom' => 10,
            'right' => 10,
        ])
        ->synchronize();
        
    $video->save($format, $output_path);

    return response()->download($output_path);

    }
                
        public function addWatermark()
        {

            // $watermark_path = URL::to("/storage/app/public/watermark.png");
        $watermark_path = public_path() . "/uploads/transcode/watermark.png";

            // $video_path = URL::to("/storage/app/public/eA81jhw9Zhgj5Wkk.mp4");
            // $output_path = URL::to("/storage/app/public/output.mp4");
        $video_path = public_path() . "/uploads/transcode/eA81jhw9Zhgj5Wkk.mp4";

        $output_path = public_path() . "/uploads/transcode/output.mp4";

            // dd($watermark_path);
            // $ffmpeg = FFMpeg::create([
            //     'ffmpeg.binaries' => '/usr/bin/ffmpeg',
            //     'ffprobe.binaries' => '/usr/bin/ffprobe',
            // ]);

            // $ffmpeg = \FFMpeg\FFMpeg::create([
            //     'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe', // tCe path to the FFMpeg binary
            //     'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
            //     'timeout'          => 0, // the timeout for the underlying process
            //     'ffmpeg.threads'   => 1,   // the number of threads that FFMpeg should use
            // ]);
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

            return response()->download($output_path->getPathname());
        }


        public function addSTorageWatermark()
        {

            // $watermark_path = URL::to("/storage/app/public/watermark.png");
        $watermark_path = public_path() . "/uploads/transcode/watermark.png";

            // $video_path = URL::to("/storage/app/public/eA81jhw9Zhgj5Wkk.mp4");
            // $output_path = URL::to("/storage/app/public/output.mp4");
        // $video_path = public_path() . "/uploads/transcode/eA81jhw9Zhgj5Wkk.mp4";

        // $output_path = public_path() . "/uploads/transcode/output.mp4";
        $settings = Setting::first();

        $video_path = storage_path() . "/app/public/eA81jhw9Zhgj5Wkk.mp4";

        $output_path = storage_path() . "/app/public/output.mp4";
        $watermark_path = public_path() . "/uploads/settings/".$settings->watermark;

            // dd($output_path);
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

            return response()->download($output_path);
        }
    



                
        public function TestClipVideo()
        {

            // $watermark_path = URL::to("/storage/app/public/watermark.png");
        $watermark_path = public_path() . "/uploads/transcode/watermark.png";

            // $video_path = URL::to("/storage/app/public/eA81jhw9Zhgj5Wkk.mp4");
            // $output_path = URL::to("/storage/app/public/output.mp4");
            $video_path = public_path() . "/uploads/transcode/input1.mp4";
            $video_path1 = public_path() . "/uploads/transcode/input2.mp4";

        $output_path = public_path() . "/uploads/transcode/outputnewa.mp4";

            // dd($watermark_path);
            $ffmpeg = \FFMpeg\FFMpeg::create();


            // $disk = FFMpeg::fromDisk('public');

                // $video1 = $ffmpeg->open($video_path);
                // $video2 = $ffmpeg->open($video_path1);
                // // $output = $ffmpeg->open($output_path);
                // $format = new X264('aac');

                // $video1->concat([
                //     $video1->getPathfile(),
                //     $video2->getPathfile(),
                // ]);

              $disk = 'local_public';
              \FFMpeg::fromDisk($disk)
                ->open(['input1.mp4', 'input2.mp4'])
                ->export()
                ->concatWithoutTranscoding()
                ->save('concatnew.mp4');


                // \FFMpeg::fromDisk($disk)
                // ->open(['input1.mp4', 'input2.mp4'])
                // ->export()
                // // ->concatWithoutTranscoding()
                // ->inFormat(new X264)

                // ->concatWithTranscoding($hasVideo = true, $hasAudio = true)
                // ->save('concatnew.mp4');

                // $video1->save($format, $output_path);

                // $ffmpeg = FFMpeg::create();

                // $video1 = $ffmpeg->open($video_path);
                // $video2 = $ffmpeg->open($video_path1);
            
                // $videos = array($video1, $video2);
            
                // $format = new X264();
                // $format->setAudioCodec("aac");
            
      
                // $format = new X264();
                // $format->setAudioCodec("aac");
            
                // $video = $ffmpeg->concat($videos)
                // ->addFilter(function ($filters) {
                //     $filters->resize(new Dimension(640, 480))
                //             ->synchronize();
                // })
                // ->save($output_path);
        }


}