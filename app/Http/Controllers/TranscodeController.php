<?php

namespace App\Http\Controllers;

use App\Jobs\TranscodeVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use URL;

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

}