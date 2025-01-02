<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use File;
use getID3;
use App\User;
use App\Video;
use Validator;
use App\Setting;
use App\Favorite;
use App\UGCVideo;
use App\Wishlist;
use FFMpeg\FFMpeg;
use App\Geofencing;
use App\LiveStream;
use App\Watchlater;
use App\HomeSetting;
use App\LikeDislike;
use App\UGCSubscriber;
use App\VideoAnalytics;
use App\MoviesSubtitles;
use Illuminate\Support\Str;
use App\PartnerMonetization;
use Illuminate\Http\Request;
use App\VideoExtractedImages;
use FFMpeg\Coordinate\TimeCode;
use App\PartnerMonetizationSetting;
use Intervention\Image\Facades\Image;
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

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:mp4,m4v,webm,ogv|max:102400',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable',
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
            $image = $request->image;

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

            if ($file != "") {

                $path = $rand . "." . $extension;
                $file->storeAs("public", $path);

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
                    $video->slug = $video_slug;
                    $video->type = 'mp4_url';
                    $video->image = !empty($video_image) ? $video_image : null;
                    $video->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Video uploaded and Waiting for Approval.',
                        'video_id' => $video->id,
                        'video_title' => $video->title,
                        'video_url' => $video->mp4_url,
                    ]);

                } else {
                    return response()->json(['success' => false, 'message' => 'Video duration exceeds the limit of 3 minutes'], 400);
                }

            }

            if ($settings->transcoding_access == 1) {
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
                    $video->slug = $video_slug;
                    $video->image = $video_image;
                    $video->save();

                    ConvertUGCVideoForStreaming::dispatch($video);

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
                $path = $rand . "." . $extension;
                $file->storeAs("public", $path);

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
                    $video->slug = $video_slug;
                    $video->image = $video_image;
                    $video->save();

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

    public function editugcvideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|exists:ugc_videos,id',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            $video = UGCVideo::find($request->video_id);

            if (!$video) {
                return response()->json(['success' => false, 'message' => 'Video not found.'], 404);
            }

            $video->title = $request->input('title');
            $video->description = $request->input('description', $video->description);

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageFilename = time() . '.' . $imageFile->getClientOriginalExtension();
                $videoImage = 'pc-image-' . $imageFilename;
                $imageFile->move(public_path('uploads/images'), $videoImage);
                $video->image = $videoImage;
            }

            $video->save();

            return response()->json([
                'success' => true,
                'message' => 'Video details updated successfully.',
                'video' => $video,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update video details.',
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

    public function revenueshare(Request $request)
    {
        try {
            $validated = $request->validate([
                'video_id' => 'required|integer|exists:videos,id',
                'user_id' => 'required|integer|exists:users,id',
                'location' => 'required|string',
                'device' => 'required|string',
            ]);

            $user = User::where('id', $validated['user_id'])->firstOrFail();
            $user_role = $user->role;
            $video = Video::find($validated['video_id']);
            $video->played_views += 1;
            $video->save();

            VideoAnalytics::create([
                'source_id' => $validated['video_id'],
                'source_type' => 'video',
                'location' => $validated['location'],
                'device' => $validated['device'],
                'viewed_in' => 'App',
            ]);

            if ($video->uploaded_by === 'Channel' && ($user_role === 'registered' || $user_role === 'subscriber' || $user_role === 'guest')) {
                $monetizationSettings = PartnerMonetizationSetting::select('viewcount_limit', 'views_amount')->first();
                $monetization_view_limit = $monetizationSettings->viewcount_limit;
                $monetization_view_amount = $monetizationSettings->views_amount;

                if ($video->played_views > $monetization_view_limit) {
                    $previously_monetized_views = $video->monetized_views ?? 0;
                    $new_monetizable_views = $video->played_views - $monetization_view_limit - $previously_monetized_views;

                    if ($new_monetizable_views > 0) {
                        $additional_amount = $new_monetizable_views * $monetization_view_amount;
                        $video->monetization_amount += $additional_amount;
                        $video->monetized_views += $new_monetizable_views;
                        $video->save();

                        $channeluser_commission = (float) $video->channeluser->commission;
                        $channel_commission = ($channeluser_commission / 100) * $video->monetization_amount;

                        $partner_monetization = PartnerMonetization::where('user_id', $video->user_id)
                            ->where('type_id', $video->id)
                            ->where('type', 'video')
                            ->first();

                        $monetization_data = [
                            'total_views' => $video->played_views,
                            'title' => $video->title,
                            'monetization_amount' => $video->monetization_amount,
                            'admin_commission' => $video->monetization_amount - $channel_commission,
                            'partner_commission' => $channel_commission,
                        ];

                        if ($partner_monetization) {
                            $partner_monetization->update($monetization_data);
                        } else {
                            PartnerMonetization::create(array_merge($monetization_data, [
                                'user_id' => $video->user_id,
                                'type_id' => $video->id,
                                'type' => 'video',
                            ]));
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'View count incremented and monetization updated',
                'video_id' => $video->id,
                'played_view' => $video->played_views,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function episoderevenueshare(Request $request)
    {
        try {
            $validated = $request->validate([
                'video_id' => 'required|integer|exists:videos,id',
                'user_id' => 'required|integer|exists:users,id',
                'location' => 'required|string',
                'device' => 'required|string',
            ]);

            $video = Episode::find($validated['video_id']);
            $video->played_views += 1;
            $video->save();

            VideoAnalytics::create([
                'source_id' => $validated['video_id'],
                'source_type' => 'episode',
                'location' => $validated['location'],
                'device' => $validated['device'],
                'viewed_in' => 'App',
            ]);

            if ($video->uploaded_by === 'Channel') {
                $monetizationSettings = PartnerMonetizationSetting::select('viewcount_limit', 'views_amount')->first();
                $monetization_view_limit = $monetizationSettings->viewcount_limit;
                $monetization_view_amount = $monetizationSettings->views_amount;

                if ($video->played_views > $monetization_view_limit) {
                    $previously_monetized_views = $video->monetized_views ?? 0;
                    $new_monetizable_views = $video->played_views - $monetization_view_limit - $previously_monetized_views;

                    if ($new_monetizable_views > 0) {
                        $additional_amount = $new_monetizable_views * $monetization_view_amount;
                        $video->monetization_amount += $additional_amount;
                        $video->monetized_views += $new_monetizable_views;
                        $video->save();

                        $channeluser_commission = (float) $video->channeluser->commission;
                        $channel_commission = ($channeluser_commission / 100) * $video->monetization_amount;

                        $partner_monetization = PartnerMonetization::where('user_id', $video->user_id)
                            ->where('type_id', $video->id)
                            ->where('type', 'episode')
                            ->first();

                        $monetization_data = [
                            'total_views' => $video->played_views,
                            'title' => $video->title,
                            'monetization_amount' => $video->monetization_amount,
                            'admin_commission' => $video->monetization_amount - $channel_commission,
                            'partner_commission' => $channel_commission,
                        ];

                        if ($partner_monetization) {
                            $partner_monetization->update($monetization_data);
                        } else {
                            PartnerMonetization::create(array_merge($monetization_data, [
                                'user_id' => $video->user_id,
                                'type_id' => $video->id,
                                'type' => 'episode',
                            ]));
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'View count incremented and monetization updated',
                'played_view' => $video->played_views,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function livestreamrevenueshare(Request $request)
    {
        try {
            $validated = $request->validate([
                'video_id' => 'required|integer|exists:videos,id',
                'location' => 'required|string',
                'device' => 'required|string',
            ]);

            $video = LiveStream::find($validated['video_id']);
            $video->played_views += 1;
            $video->save();

            VideoAnalytics::create([
                'source_id' => $validated['video_id'],
                'source_type' => 'livestream',
                'location' => $validated['location'],
                'device' => $validated['device'],
                'viewed_in' => 'App',
            ]);

            if ($video->uploaded_by === 'Channel') {
                $monetizationSettings = PartnerMonetizationSetting::select('viewcount_limit', 'views_amount')->first();
                $monetization_view_limit = $monetizationSettings->viewcount_limit;
                $monetization_view_amount = $monetizationSettings->views_amount;

                if ($video->played_views > $monetization_view_limit) {
                    $previously_monetized_views = $video->monetized_views ?? 0;
                    $new_monetizable_views = $video->played_views - $monetization_view_limit - $previously_monetized_views;

                    if ($new_monetizable_views > 0) {
                        $additional_amount = $new_monetizable_views * $monetization_view_amount;
                        $video->monetization_amount += $additional_amount;
                        $video->monetized_views += $new_monetizable_views;
                        $video->save();

                        $channeluser_commission = (float) $video->channeluser->commission;
                        $channel_commission = ($channeluser_commission / 100) * $video->monetization_amount;

                        $partner_monetization = PartnerMonetization::where('user_id', $video->user_id)
                            ->where('type_id', $video->id)
                            ->where('type', 'livestream')
                            ->first();

                        $monetization_data = [
                            'total_views' => $video->played_views,
                            'title' => $video->title,
                            'monetization_amount' => $video->monetization_amount,
                            'admin_commission' => $video->monetization_amount - $channel_commission,
                            'partner_commission' => $channel_commission,
                        ];

                        if ($partner_monetization) {
                            $partner_monetization->update($monetization_data);
                        } else {
                            PartnerMonetization::create(array_merge($monetization_data, [
                                'user_id' => $video->user_id,
                                'type_id' => $video->id,
                                'type' => 'livestream',
                            ]));
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'View count incremented and monetization updated',
                'played_view' => $video->played_views,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ugcsubscribe(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscriber_id' => 'required',
        ]);

        try {

            $user = User::find($request->user_id);
            $subscriber = User::find($request->subscriber_id);

            $exists = UGCSubscriber::where('user_id', $user->id)
                ->where('subscriber_id', $subscriber->id)
                ->exists();

            if (!$exists) {
                UGCSubscriber::create([
                    'user_id' => $user->id,
                    'subscriber_id' => $subscriber->id,
                ]);
            }

            $subscriberCount = UGCSubscriber::where('user_id', $user->id)->count();

            return response()->json([
                'success' => true,
                'count' => $subscriberCount,
                'message' => 'Successfully subscribed.',
            ]);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error occurred.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function ugcunsubscribe(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'unsubscriber_id' => 'required',
        ]);

        try {

            $user = User::find($request->user_id);
            $unsubscriber = User::find($request->unsubscriber_id);

            $subscription = UGCSubscriber::where('user_id', $user->id)
                ->where('subscriber_id', $unsubscriber->id);

            if ($subscription->exists()) {
                $subscription->delete();

                $subscriberCount = UGCSubscriber::where('user_id', $user->id)->count();

                return response()->json([
                    'success' => true,
                    'count' => $subscriberCount,
                    'message' => 'Successfully unsubscribed.',
                ]);
            }

            return response()->json([
                'error' => 'Subscription not found.',
            ], 404);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error occurred.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function ugcvideodetail(Request $request)
    {
        $data = $request->all();
        $videoid = $request->videoid;
        $user_id = $request->user_id;
        try {
            $videodetail = UGCVideo::where('id', $videoid)
                ->orderBy('created_at', 'desc')
                ->get();
            if ($videodetail->isEmpty()) {
                return response()->json(['message' => 'No video found'], 404);
            }
            $videodetail = $videodetail->map(function ($item) use ($request) {
                $item['details'] = $item->details ? strip_tags($item->details) : null;
                $item['description'] = $item->description ? strip_tags(html_entity_decode($item->description)) : null;
                $item['image_url'] = URL::to('public/uploads/images/' . $item->image);
                $item['player_image'] = URL::to('public/uploads/images/' . $item->player_image);
                $item['mobile_image_url'] = URL::to('public/uploads/images/' . $item->mobile_image);
                $item['tablet_image_url'] = URL::to('public/uploads/images/' . $item->tablet_image);
                $item['video_url'] = URL::to('/') . '/storage/app/public/';
                $item['transcoded_url'] = URL::to('/storage/app/public/') . '/' . $item->path . '.m3u8';
                $item['movie_duration'] = gmdate('H:i:s', $item->duration);
                switch (true) {
                    case $item['type'] == "mp4_url":
                        $item['videos_url'] = $item->mp4_url;
                        $item['video_player_type'] = 'video/mp4';
                        $item['qualities'] = [];
                        break;
                    case $item['type'] == "m3u8_url":
                        $item['videos_url'] = $item->m3u8_url;
                        $item['video_player_type'] = 'application/x-mpegURL';
                        $item['qualities'] = [];
                        break;
                    case $item['type'] == "embed":
                        $item['videos_url'] = $item->embed_code;
                        $item['video_player_type'] = 'embed';
                        $item['qualities'] = [];
                        break;
                    case $item['type'] == null && pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mp4":
                        $item['videos_url'] = URL::to('/storage/app/public/' . $item->path . '.m3u8');
                        $item['video_player_type'] = 'application/x-mpegURL';
                        $item['qualities'] = [];
                        break;
                    case $item['type'] == null && pathinfo($item['mp4_url'], PATHINFO_EXTENSION) == "mov":
                        $item['videos_url'] = $item->mp4_url;
                        $item['video_player_type'] = 'video/mp4';
                        $item['qualities'] = [];
                        break;
                    case $item['type'] == null:
                        $item['videos_url'] = URL::to('/storage/app/public/' . $item->path . '.m3u8');
                        $item['video_player_type'] = 'application/x-mpegURL';
                        $item['qualities'] = [];
                        break;
                    case $item['type'] == " " && !is_null($item->transcoded_url):
                        $item['videos_url'] = $item->transcoded_url;
                        $item['video_player_type'] = 'application/x-mpegURL';
                        $item['qualities'] = [];
                        break;
                    default:
                        $item['videos_url'] = null;
                        $item['video_player_type'] = null;
                        $item['qualities'] = [];
                        break;
                }
                return $item;
            });

            if (isset($request->user_id) && $request->user_id != '') {
                $user_id = $request->user_id;

                $cnt = Wishlist::select('ugc_video_id')->where('user_id', '=', $user_id)->where('ugc_video_id', '=', $videoid)->count();
                $wishliststatus = ($cnt == 1) ? "true" : "false";

                //Watchlater
                $cnt1 = Watchlater::select('ugc_video_id')->where('user_id', '=', $user_id)->where('ugc_video_id', '=', $videoid)->count();
                $watchlaterstatus = ($cnt1 == 1) ? "true" : "false";

                $userrole = User::where('id', '=', $user_id)->first()->role;
                $status = 'true';

                $like_data = LikeDisLike::where("ugc_video_id", "=", $videoid)->where("user_id", "=", $user_id)->where("liked", "=", 1)->count();
                $dislike_data = LikeDisLike::where("ugc_video_id", "=", $videoid)->where("user_id", "=", $user_id)->where("disliked", "=", 1)->count();
                $like = ($like_data == 1) ? "true" : "false";
                $dislike = ($dislike_data == 1) ? "true" : "false";
            } else {
                $wishliststatus = 'false';
                $watchlaterstatus = 'false';
                $userrole = '';
                $status = 'true';
                $like = "false";
                $dislike = "false";
            }

            // andriodId  Wishlist , Watchlater
            if (!empty($request->andriodId)) {
                //Wishlilst
                $Wishlist_cnt = Wishlist::select('ugc_video_id')->where('andriodId', '=', $request->andriodId)->where('ugc_video_id', '=', $videoid)->count();
                $andriod_wishliststatus = ($Wishlist_cnt == 1) ? "true" : "false";

                // Watchlater
                $cnt1 = Watchlater::select('ugc_video_id')->where('andriodId', '=', $request->andriodId)->where('ugc_video_id', '=', $videoid)->count();
                $andriod_watchlaterstatus = ($cnt1 == 1) ? "true" : "false";
                $like_data = LikeDisLike::where("ugc_video_id", "=", $videoid)->where("andriodId", "=", $request->andriodId)->where("liked", "=", 1)->count();
                $dislike_data = LikeDisLike::where("ugc_video_id", "=", $videoid)->where("andriodId", "=", $request->andriodId)->where("disliked", "=", 1)->count();
                $andriod_like = ($like_data == 1) ? "true" : "false";
                $andriod_dislike = ($dislike_data == 1) ? "true" : "false";
            } else {
                $andriod_wishliststatus = 'false';
                $andriod_watchlaterstatus = 'false';
                $andriod_like = "false";
                $andriod_dislike = "false";
            }

            // IOS Wishlist , Watchlater
            if (!empty($request->IOSId)) {

                //Wishlilst
                $Wishlist_cnt = Wishlist::select('ugc_video_id')->where('IOSId', '=', $request->IOSId)->where('ugc_video_id', '=', $videoid)->count();
                $IOS_wishliststatus = ($Wishlist_cnt == 1) ? "true" : "false";

                // Watchlater
                $cnt1 = Watchlater::select('ugc_video_id')->where('IOSId', '=', $request->IOSId)->where('ugc_video_id', '=', $videoid)->count();
                $IOS_watchlaterstatus = ($cnt1 == 1) ? "true" : "false";

                $like_data = LikeDisLike::where("ugc_video_id", "=", $videoid)->where("IOSId", "=", $request->IOSId)->where("liked", "=", 1)->count();
                $dislike_data = LikeDisLike::where("ugc_video_id", "=", $videoid)->where("IOSId", "=", $request->IOSId)->where("disliked", "=", 1)->count();
                $IOS_like = ($like_data == 1) ? "true" : "false";
                $IOS_dislike = ($dislike_data == 1) ? "true" : "false";

            } else {
                $IOS_wishliststatus = 'false';
                $IOS_watchlaterstatus = 'false';
                $IOS_like = "false";
                $IOS_dislike = "false";
            }

            // TVID Wishlist
            if (!empty($request->tv_id)) {
                $Wishlist_cnt = Wishlist::select('ugc_video_id')->where('tv_id', '=', $request->tv_id)->where('ugc_video_id', '=', $videoid)->count();
                $tv_wishliststatus = ($Wishlist_cnt == 1) ? "true" : "false";
            } else {
                $tv_wishliststatus = 'false';
            }

            $moviesubtitles = MoviesSubtitles::where('movie_id', $videoid)->get();

            $response = array(
                'status' => $status,
                'wishlist' => $wishliststatus,
                'andriod_wishliststatus' => $andriod_wishliststatus,
                'andriod_like' => $andriod_like,
                'andriod_dislike' => $andriod_dislike,
                'andriod_watchlaterstatus' => $andriod_watchlaterstatus,
                'tv_wishliststatus' => $tv_wishliststatus,
                'watchlater' => $watchlaterstatus,
                'userrole' => $userrole,
                'shareurl' => URL::to('ugc/video-player').'/'.$videodetail[0]->slug,
                'like' => $like,
                'dislike' => $dislike,
                'videodetail' => $videodetail,
                'videossubtitles' => $moviesubtitles,
                'IOS_wishliststatus' => $IOS_wishliststatus,
                'IOS_watchlaterstatus' => $IOS_watchlaterstatus,
                'IOS_like' => $IOS_like,
                'IOS_dislike' => $IOS_dislike,
            );
        } catch (\Throwable $th) {
            $response = array(
                'status' => 'false',
                'message' => $th->getMessage(),
            );
        }

        return response()->json($response, 200);
    }

    public function ugcwishlist(Request $request)
    {

        $user_id = $request->user_id;
        $ugc_video_id = $request->ugc_video_id;

        if (!empty($ugc_video_id)) {
            $count = Wishlist::where('user_id', $user_id)->where('ugc_video_id', $ugc_video_id)->count();

            if ($count > 0) {
                Wishlist::where('user_id', $user_id)->where('ugc_video_id', $ugc_video_id)->delete();

                $response = [
                    'status' => 'false',
                    'message' => 'Removed From Your Wishlist',
                ];
            } else {
                $data = ['user_id' => $user_id, 'ugc_video_id' => $ugc_video_id];
                Wishlist::insert($data);

                $response = [
                    'status' => 'true',
                    'message' => 'Added to Your Wishlist',
                ];
            }
        }
        return response()->json($response, 200);

    }

    public function ugcwatchlater(Request $request)
    {

        $user_id = $request->user_id;
        $ugc_video_id = $request->ugc_video_id;
        if ($request->ugc_video_id != '') {
            $count = Watchlater::where('user_id', '=', $user_id)->where('ugc_video_id', '=', $ugc_video_id)->count();
            if ($count > 0) {
                Watchlater::where('user_id', '=', $user_id)->where('ugc_video_id', '=', $ugc_video_id)->delete();
                $response = array(
                    'status' => 'false',
                    'message' => 'Removed From Your Watch Later',
                );
            } else {
                $data = array('user_id' => $user_id, 'ugc_video_id' => $ugc_video_id);
                Watchlater::insert($data);
                $response = array(
                    'status' => 'true',
                    'message' => 'Added to Your Watch Later',
                );

            }
        }
        return response()->json($response, 200);
    }

    public function showUgcProfileApi(Request $request)
    {
        $ugc_user_id = $request->input('ugc_user_id');
        $user_id = $request->input('user_id');

        if (!$ugc_user_id) {
            return response()->json(['error' => 'User ID is required.'], 400);
        }
        $user = User::where('id', $ugc_user_id)->withCount('subscribers')->firstOrFail();

        $ugcvideos = UGCVideo::where('user_id', $user->id)
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        if (isset($request->user_id) && $request->user_id != '') {
            $user_id = $request->user_id;
            $cnt = UGCSubscriber::where('user_id', '=', $ugc_user_id)->where('subscriber_id', '=', $user_id)->count();
            $subscribed = ($cnt == 1) ? "true" : "false";
        } else {
            $subscribed = "false";
        }

        $ugc_total = $user->ugcVideos();
        $totalViews = $ugc_total->sum('views');
        $totalVideos = $ugc_total->where('active', 1)->count();

        $data = [
            'user' => $user,
            'ugcvideos' => $ugcvideos,
            'totalViews' => $totalViews,
            'totalVideos' => $totalVideos,
            'subscribed' => $subscribed,
        ];

        return response()->json($data);
    }

    public function EpisodePartnerMonetization(Request $request)
    {
        try {
            $video_id = $request->video_id;
            $video = Episode::where('id', $video_id)->first();
            if ($video) {
                $video->played_views += 1;
                $video->save();
                $monetizationSettings = PartnerMonetizationSetting::select('viewcount_limit', 'views_amount')->first();

                if ($monetizationSettings) {
                    $monetization_view_limit = $monetizationSettings->viewcount_limit;
                    $monetization_view_amount = $monetizationSettings->views_amount;

                    if ($video->played_views > $monetization_view_limit) {
                        $previously_monetized_views = $video->monetized_views ?? 0;
                        $new_monetizable_views = $video->played_views - $monetization_view_limit - $previously_monetized_views;

                        if ($new_monetizable_views > 0) {

                            $additional_amount = $new_monetizable_views * $monetization_view_amount;
                            $video->monetization_amount += $additional_amount;
                            $video->monetized_views += $new_monetizable_views;
                            $video->save();

                            $channeluser_commission = (float) $video->channeluser->commission;
                            $channel_commission = ($channeluser_commission / 100) * $video->monetization_amount;

                            $partner_monetization = PartnerMonetization::where('user_id', $video->user_id)
                                ->where('type_id', $video->id)
                                ->where('type', 'episode')->first();

                            $monetization_data = [
                                'total_views' => $video->played_views,
                                'title' => $video->title,
                                'monetization_amount' => $video->monetization_amount,
                                'admin_commission' => $video->monetization_amount - $channel_commission,
                                'partner_commission' => $channel_commission,
                            ];

                            if ($partner_monetization) {
                                $partner_monetization->update($monetization_data);
                            } else {
                                PartnerMonetization::create(array_merge($monetization_data, [
                                    'user_id' => $video->user_id,
                                    'type_id' => $video->id,
                                    'type' => 'episode',
                                ]));
                            }
                        }
                    }

                    return response()->json(['message' => 'View count incremented and monetization updated', 'played_view' => $video->played_views, 'monetization_amount' => $video->monetization_amount], 200);
                } else {
                    return response()->json(['error' => 'Video not found'], 404);
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function relatedradiostations(Request $request)
    {

        $validated = $request->validate([
            'radio_station_id' => 'required|integer|exists:live_streams,id',
        ]);

        $radio_station_id = $validated['radio_station_id'];

        $radiostation = LiveStream::where('id', '!=', $radio_station_id)
                                ->where('stream_upload_via', 'radio_station')
                                ->get()
                                ->map(function ($item) {
                                    $item['image'] = URL::to('/').'/public/uploads/images/'.$item->image;
                                    return $item;
                                });

        $response = [
            'status' => true,
            'radiostation' => $radiostation,
        ];

        return response()->json($response, 200);
    }

    public function ugclike(Request $request)
    {
        $user_id = $request->user_id;
        $ugc_video_id = $request->ugc_video_id;
        $likeDislike = LikeDislike::where('ugc_video_id', $ugc_video_id)
                                    ->where('user_id', $user_id)
                                    ->first();

        if ($likeDislike) {
            if ($likeDislike->liked == 1) {
                $likeDislike->update([
                    'liked' => 0,
                    'disliked' => 0,
                ]);
            } else {
                $likeDislike->update([
                    'liked' => 1,
                    'disliked' => 0,
                ]);
            }
        } else {
            LikeDislike::create([
                'user_id' => $user_id,
                'ugc_video_id' => $ugc_video_id,
                'liked' => 1,
                'disliked' => 0,
            ]);
        }

        $status = LikeDislike::where('ugc_video_id', $ugc_video_id)
                                ->where('user_id', $user_id)
                                ->select('liked', 'disliked')
                                ->first();
        return response()->json([
            'status' => 'true',
            'like' => $status->liked,
            'dislike' => $status->disliked,
        ], 200);
    }

  
    public function ugcdislike(Request $request)
    {
        $user_id = $request->user_id;
        $ugc_video_id = $request->ugc_video_id;
        $likeDislike = LikeDislike::where('ugc_video_id', $ugc_video_id)
                                  ->where('user_id', $user_id)
                                  ->first();
    
        if ($likeDislike) {
            if ($likeDislike->disliked == 1) {
                $likeDislike->update([
                    'liked' => 0,
                    'disliked' => 0,
                ]);
            } else {
                $likeDislike->update([
                    'liked' => 0,
                    'disliked' => 1,
                ]);
            }
        } else {
            LikeDislike::create([
                'user_id' => $user_id,
                'ugc_video_id' => $ugc_video_id,
                'liked' => 0,
                'disliked' => 1,
            ]);
        }
    
        $status = LikeDislike::where('ugc_video_id', $ugc_video_id)
                             ->where('user_id', $user_id)
                             ->select('liked', 'disliked')
                             ->first();
    
        return response()->json([
            'status' => 'true',
            'like' => $status->liked,
            'dislike' => $status->disliked,
        ], 200);
    }

    public function add_favorite_ugcvideo(Request $request) {

        try {
          
          $user_id = $request->user_id;
          $ugc_video_id = $request->ugc_video_id;
    
          if (!empty($ugc_video_id)) {
              $count = Favorite::where('user_id', $user_id)->where('ugc_video_id', $ugc_video_id)->count();
    
              if ($count > 0) {
                  Favorite::where('user_id', $user_id)->where('ugc_video_id', $ugc_video_id)->delete();
    
                  $response = [
                      'status' => 'false',
                      'message' => 'Removed From Your Favorite'
                  ];
              } else {
                  $data = ['user_id' => $user_id, 'ugc_video_id' => $ugc_video_id];
                  Favorite::insert($data);
    
                  $response = [
                        'status' => 'true',
                        'message' => 'Added to Your Favorite'
                    ];
                }
          }
        } catch (\Throwable $th) {
            $response = [
              'status' => 'false',
              'message' => $th->getMessage(),
            ];
        }
    
        return response()->json($response, 200);
    
    }
    

}
