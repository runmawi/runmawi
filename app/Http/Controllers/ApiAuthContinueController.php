<?php

namespace App\Http\Controllers;

use App\Geofencing;
use App\HomeSetting;
use App\Setting;
use App\UGCVideo;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ApiAuthContinueController extends Controller
{

    public function __construct()
    {
        $this->settings = Setting::first();
        $this->getfeching = Geofencing::first();
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
    }

    public function ugcvideolist()
    {
        $ugcvideos = UGCVideo::where('active', 1)->get();
        return $ugcvideos;
    }

    public function uploadugcvideo(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:mp4,m4v,webm,ogv|max:102400',
            'user_id' => 'required|exists:users,id', // Ensure user ID exists
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
          
            $userId = $request->input('user_id');
            $video_title = $request->input('title');
            $video_description = $request->input('description');

            $file = $request->file('file');
            $original_name = $request->file->getClientOriginalName() ? $request->file->getClientOriginalName() : "";
            $extension = $file->getClientOriginalExtension();
            $randomName = Str::random(16) . '.' . $extension;

            $file->storeAs('videos', $randomName, 'public');
            $storagePath = asset('storage/videos/' . $randomName);

            $getID3 = new \getID3();
            $fileInfo = $getID3->analyze(storage_path('app/public/videos/' . $randomName));
            $duration = $fileInfo['playtime_seconds'] ?? 0;

            if ($duration > 180) {
                return response()->json(['success' => false, 'message' => 'Video duration exceeds 3 minutes'], 400);
            }

            // Save video details
            $video = new UGCVideo();
            $video->user_id = $userId;
            $video->title = $video_title;
            $video->description = $video_description;
            $video->disk = "public";
            $video->original_name = "public";
            $video->path = $randomName;
            $video->mp4_url = $storagePath;
            $video->duration = $duration;
            $video->draft = 0;
            $video->save();

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully and waiting for Approval ',
                'data' => [
                    'video_id' => $video->id,
                    'video_title' => $video->original_name,
                    'video_url' => $video->mp4_url,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Video upload failed', 'error' => $e->getMessage()], 500);
        }
    }

}
