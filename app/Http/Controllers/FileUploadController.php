<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test as Video;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
//use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    function index()
    {
//        if ($user->subscriptions){
//            
//        }
     return view('file_upload');
    }

       public function fileStore(Request $request)
    {
        $request->validate([
            'video' => 'required',
        ]);
        
       // $fileName = time().'.'.request()->file->getClientOriginalExtension();
 
//        $request->file->move(public_path('images'), $fileName);
//        $fileupload = new FileUpload;
//        $fileupload->filename=$fileName;
//        $fileupload->save();
//        
       $rand = Str::random(16);
        
        $path = $rand . '.' . $request->video->getClientOriginalExtension();
        $request->video->storeAs('public', $path);
 
        $video = Video::create([
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => 'ghfg',
        ]);
 
        $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
        $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
        $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);

        $converted_name = $this->getCleanFileName($video->path);
        
//        // open the uploaded video from the right disk...
//        FFMpeg::fromDisk($video->disk)
//            ->open($video->path)
//            ->addFilter(function ($filters) {
//                $filters->resize(new Dimension(960, 540));
//            })
//            ->export()
//            ->toDisk('local')
//            ->inFormat($lowBitrateFormat)
//            ->save($converted_name);
           
            // open the uploaded video from the right disk...
        FFMpeg::fromDisk($video->disk)
            ->open($video->path)
            ->exportForHLS()
            ->toDisk('local')
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)
            ->save($video->id . '.m3u8');
           
       
       
         return redirect('/uploader')
            ->with(
                'message',
                'Your video will be available shortly after we process it'
            );
        
    }
    
     private function getCleanFileName($filename){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) . '.mp4';
    }
}