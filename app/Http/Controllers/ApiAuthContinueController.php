<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use getID3;
use App\User;
use Validator;
use App\Setting;
use App\UGCVideo;
use FFMpeg\FFMpeg;
use File;
use App\Geofencing;
use App\HomeSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\VideoExtractedImages;
use Intervention\Image\Facades\Image;
use FFMpeg\Coordinate\TimeCode;
use App\Jobs\ConvertUGCVideoForStreaming;

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
        // Validation
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:mp4,m4v,webm,ogv|max:102400',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {

            $userId = $request->user_id;
            $video_title = $request->title;
            $video_description = $request->description;
            $video_slug = $request->slug ? $request->slug : $request->title;
            $file = $request->file;
            
            if ($request->hasFile('image')) {
                $imagefile = $request->image;
                if (compress_image_enable() == 1) {
                    $image_filename = time() . '.' . compress_image_format();
                    $video_image = 'pc-image-' . $image_filename;
                    $Mobile_image = 'Mobile-image-' . $image_filename;
                    $Tablet_image = 'Tablet-image-' . $image_filename;
    
                    Image::make($imagefile)->save(base_path() . '/public/uploads/images/' . $video_image, compress_image_resolution());
                    Image::make($imagefile)->save(base_path() . '/public/uploads/images/' . $Mobile_image, compress_image_resolution());
                    Image::make($imagefile)->save(base_path() . '/public/uploads/images/' . $Tablet_image, compress_image_resolution());
                } else {
                    $image_filename = time() . '.' . $imagefile->getClientOriginalExtension();
    
                    $video_image = 'pc-image-' . $image_filename;
                    $Mobile_image = 'Mobile-image-' . $image_filename;
                    $Tablet_image = 'Tablet-image-' . $image_filename;
    
                    Image::make($imagefile)->save(base_path() . '/public/uploads/images/' . $video_image);
                    Image::make($imagefile)->save(base_path() . '/public/uploads/images/' . $Mobile_image);
                    Image::make($imagefile)->save(base_path() . '/public/uploads/images/' . $Tablet_image);
                }
    
                $data["image"] = $video_image;
                $data["mobile_image"] = $Mobile_image;
                $data["tablet_image"] = $Tablet_image;
            }


            $original_name = $file->getClientOriginalName() ?: '';
            $extension = $file->getClientOriginalExtension();
            $rand = Str::random(16);
            $randomName = $rand . '.' . $extension;

            $file->storeAs('videos', $randomName, 'public');
            $storepath = URL::to("/storage/app/public/" . $randomName);

            $getID3 = new \getID3();
            $fileInfo = $getID3->analyze(storage_path('app/public/videos/' . $randomName));
            $duration = $fileInfo['playtime_seconds'] ?? 0;

            $user = User::find($userId);
            $package = $user->package;  
            $settings = Setting::first();
            
            if ($duration > 180) {
                return response()->json(['success' => false, 'message' => 'Video duration exceeds 3 minutes'], 400);
            }


            if ($file != "" && $package != "Business") {

                $path = $rand . "." . $extension;
                $file->storeAs("public", $path);

                // Get video duration and save video record
                $getID3 = new getID3();
                $videoStorePath = storage_path("app/public/" . $path);
                $videoInfo = $getID3->analyze($videoStorePath);
                $videoDuration = $videoInfo["playtime_seconds"];

                if ($videoDuration < 180) {
                    $video = new UGCVideo();
                    $video->disk = "public";
                    $video->status = 0;
                    $video->original_name = $original_name;
                    $video->path = $path;
                    $video->title = $video_title;
                    $video->mp4_url = $storepath;
                    $video->draft = 0;
                    $video->image = default_vertical_image();
                    $video->video_tv_image = default_horizontal_image();
                    $video->player_image = default_horizontal_image();
                    $video->user_id = $userId;
                    $video->duration = $videoDuration;
                    $video->slug =  $video_slug;
                    $video->type =  'mp4_url';
                    $video->image = $video_image;
                    $video->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Video uploaded and Waiting for Approval.',
                        'video_id' => $video->id,
                        'video_title' => $video->title,
                        'video_url' => $video->mp4_url,
                    ]);

                }
                else
                {
                    return response()->json(['success' => false, 'message' => 'Video duration exceeds the limit of 3 minutes'], 400);
                }


            } 
            
            if ($package == "Business" && $settings->transcoding_access == 1) {
                $path = $rand . "." . $extension;
                $file->storeAs("public", $path);

                // Get video duration and save video record
                $getID3 = new getID3();
                $videoStorePath = storage_path("app/public/" . $path);
                $videoInfo = $getID3->analyze($videoStorePath);
                $videoDuration = $videoInfo["playtime_seconds"];

                if ($videoDuration < 180) {
                    $video = new UGCVideo();
                    $video->disk = "public";
                    $video->status = 0;
                    $video->original_name = $original_name;
                    $video->path = $path;
                    $video->title = $video_title;
                    $video->mp4_url = $storepath;
                    $video->draft = 0;
                    $video->image = default_vertical_image();
                    $video->video_tv_image = default_horizontal_image();
                    $video->player_image = default_horizontal_image();
                    $video->user_id = $userId;
                    $video->duration = $videoDuration;
                    $video->slug =  $video_slug;
                    $video->image = $video_image;
                    $video->save();

                    // Dispatch video transcoding job
                    ConvertUGCVideoForStreaming::dispatch($video);

                    // Extract images from the video if enabled
                    if (Enable_Extract_Image() == 1) {
                        $this->extractImagesFromVideo($video, $videoStorePath, $rand, $videoDuration);
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Video uploaded and processing started.',
                        'video_id' => $video->id,
                        'video_title' => $video->title,
                        'video_url' => $video->mp4_url,
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Video duration exceeds the limit of 3 minutes'], 400);
                }
            } elseif ($package == "Business" && $settings->transcoding_access == 0) {
                // Video processing for Business package without transcoding access
                $path = $rand . "." . $extension;
                $file->storeAs("public", $path);

                // Get video duration and save video record
                $getID3 = new getID3();
                $videoStorePath = storage_path("app/public/" . $path);
                $videoInfo = $getID3->analyze($videoStorePath);
                $videoDuration = $videoInfo["playtime_seconds"];

                if ($videoDuration < 180) {
                    $video = new UGCVideo();
                    $video->disk = "public";
                    $video->title = $video_title;
                    $video->original_name = $original_name;
                    $video->path = $path;
                    $video->mp4_url = $storepath;
                    $video->type = "mp4_url";
                    $video->draft = 0;
                    $video->image = default_vertical_image();
                    $video->video_tv_image = default_horizontal_image();
                    $video->player_image = default_horizontal_image();
                    $video->user_id = $userId;
                    $video->duration = $videoDuration;
                    $video->slug =  $video_slug;
                    $video->image = $video_image;
                    $video->save();

                    // Extract images if enabled
                    if (Enable_Extract_Image() == 1) {
                        $this->extractImagesFromVideo($video, $videoStorePath, $rand, $videoDuration);
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Video uploaded and Waiting for Approval!',
                        'video_id' => $video->id,
                        'video_title' => $video->title,
                        'video_url' => $video->mp4_url,
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Video duration exceeds the limit of 3 minutes'], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid package type or transcoding access is restricted.',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Video upload failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function extractImagesFromVideo($video, $videoStorePath, $rand, $videoDuration)
    {
        $ffmpeg = FFMpeg::create();
        $videoFrame = $ffmpeg->open($videoStorePath);

        $frameWidth = 1280;
        $frameHeight = 720;
        $frameWidthPortrait = 1080;
        $frameHeightPortrait = 1920;
        $randportrait = 'portrait_' . $rand;

        // Define the timecodes for extracting images
        $interval = 5; // Interval for extracting frames in seconds
        $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
        $totalDuration = intval($totalDuration);

        // Define different timecodes based on video length
        $timecodes = ($totalDuration > 600) ? [5, 120, 240, 360, 480] : [5, 10, 15, 20, 25];

        foreach ($timecodes as $index => $time) {
            $imagePortraitPath = public_path("uploads/images/{$video->id}_{$randportrait}_{$index}.jpg");
            $imagePath = public_path("uploads/images/{$video->id}_{$rand}_{$index}.jpg");

            try {
                // Save extracted frames as images
                $videoFrame->frame(TimeCode::fromSeconds($time))
                    ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));

                $videoFrame->frame(TimeCode::fromSeconds($time))
                    ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));

                // Save image details
                $VideoExtractedImage = new VideoExtractedImages();
                $VideoExtractedImage->user_id = Auth::user()->id;
                $VideoExtractedImage->socure_type = 'UGC Video';
                $VideoExtractedImage->video_id = $video->id;
                $VideoExtractedImage->image_path = URL::to("/uploads/images/" . $video->id . '_' . $rand . '_' . $index . '.jpg');
                $VideoExtractedImage->portrait_image = URL::to("/uploads/images/" . $video->id . '_' . $randportrait . '_' . $index . '.jpg');
                $VideoExtractedImage->image_original_name = $video->id . '_' . $rand . '_' . $index . '.jpg';
                $VideoExtractedImage->save();
            } catch (\Exception $e) {
                // Handle error for image extraction failure
                Log::error("Error extracting video frame: " . $e->getMessage());
            }
        }
    }

    public function deleteugcvideo(Request $request)
    {
        try {
    
            $request->validate([
                'ugc_video_id' => 'required|exists:ugc_videos,id',
            ]);
    
            $video = UGCVideo::find($request->ugc_video_id);

            if (!$video) {
                return response()->json(['success' => false, 'message' => 'Video not found'], 404);
            }

            $imagePaths = [
                'image' => $video->image,
                'player_image' => $video->player_image,
                'video_title_image' => $video->video_title_image,
            ];

            foreach ($imagePaths as $key => $path) {
                if (!empty($path) && $path !== "default_image" && $path !== "default_horizontal_image") {
                    $fullPath = base_path('public/uploads/images/' . $path);
                    if (File::exists($fullPath)) {
                        File::delete($fullPath);
                    }
                }
            }

            $directory = storage_path('app/public');
            if (!is_null($video->path)) {
                $info = pathinfo($video->path);
                $pattern = $video->path ? $info['filename'] . '*' : '';
                $files = glob($directory . '/' . $pattern);

                foreach ($files as $file) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }

            $video->delete();

            return response()->json(['success' => true, 'message' => 'Video deleted successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the video.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

}
