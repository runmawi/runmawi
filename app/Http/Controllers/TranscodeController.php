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


class TranscodeController extends Controller
{
    /**
     * Store a new podcast.
     *
     * @param  Request  $request
     * @return Response
     */
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

            $watermark_path = URL::to("/storage/app/public/watermark.png");
        $watermark_path = public_path() . "/uploads/watermark.png";

            // $video_path = URL::to("/storage/app/public/eA81jhw9Zhgj5Wkk.mp4");
            // $output_path = URL::to("/storage/app/public/output.mp4");
        $video_path = public_path() . "/uploads/eA81jhw9Zhgj5Wkk.mp4";

        $output_path = public_path() . "/uploads/output.mp4";

            // dd($watermark_path);
            // $ffmpeg = FFMpeg::create([
            //     'ffmpeg.binaries' => '/usr/bin/ffmpeg',
            //     'ffprobe.binaries' => '/usr/bin/ffprobe',
            // ]);

            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe', // tCe path to the FFMpeg binary
                'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
                'timeout'          => 0, // the timeout for the underlying process
                'ffmpeg.threads'   => 1,   // the number of threads that FFMpeg should use
            ]);

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

    

}