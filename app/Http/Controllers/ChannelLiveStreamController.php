<?php
namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Session;
use App\Setting as Setting;
use Illuminate\Support\Str;
use App\Users as Users;
use App\LiveLanguage as LiveLanguage;
use App\CategoryLive as CategoryLive;
use App\RTMP;
use Streaming\Representation;
use App\InappPurchase;
use App\Channel;
use App\EmailTemplate;
use Mail;
use App\SiteTheme;
use App\ChannelSubscription;
use App\CompressImage;

class ChannelLiveStreamController extends Controller
{


    public function __construct()
    {
        $this->enable_channel_Monetization = SiteTheme::pluck('enable_channel_Monetization')->first();
    }

    public function Channelindex()
    {
        $Stream_key = Session::get('Stream_key');
        $Stream_error = Session::get('Stream_error');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');

        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;

            $all = LiveStream::all();
            if (!empty($search_value)):
                $videos = LiveStream::where('user_id', '=', $user_id)->where('title', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')
                    ->paginate(9);
            else:
                $videos = LiveStream::where('user_id', '=', $user_id)->orderBy('created_at', 'DESC')
                    ->paginate(9);
            endif;

            // $user = Auth::user();
            $data = array(
                'videos' => $videos,
                // 'user' => $user,
                // 'admin_user' => Auth::user()
                'settings' => Setting::first() ,
                'Stream_key' => $Stream_key,
                'Video_encoder_Status' => 1,
                'Settings' => Setting::first() ,
                'Stream_error' => $Stream_error ? $Stream_error : 0,
                'Rtmp_url' => $Rtmp_url ? $Rtmp_url : null,
                'title' => $title ? $title : null,
            );

            return View('channel.livestream.index', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }
    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function Channelcreate()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        $user = Session::get('channel'); 
        $user_id = $user->id;
        $compress_image_settings = CompressImage::first();
        
        if($this->enable_channel_Monetization == 1){

            $ChannelSubscription = ChannelSubscription::where('user_id', '=', $user_id)->count(); 
            
            if($ChannelSubscription == 0 ){
                return View::make('channel.becomeSubscriber');
            }elseif($ChannelSubscription > 0){

                $ChannelSubscription = ChannelSubscription::where('channel_subscriptions.user_id', '=', $user_id)->orderBy('channel_subscriptions.created_at', 'DESC')
                                        ->join('channel_subscription_plans', 'channel_subscription_plans.plan_id', '=', 'channel_subscriptions.stripe_plan')
                                        ->first(); 

                if( !empty($ChannelSubscription) ){

                    $upload_live_limit = $ChannelSubscription->upload_live_limit;
                    $uploaded_lives = Livestream::where('uploaded_by','Channel')->where('user_id', '=', $user_id)->count();
                    if($upload_live_limit != null && $upload_live_limit != 0){
                        if($upload_live_limit <= $uploaded_lives){
                            return View::make('channel.expired_upload');
                        }
                    }
                }else{
                    return View::make('channel.becomeSubscriber');
                }
                
            }else{
                return View::make('channel.becomeSubscriber');
            }
        }

        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;

            $data = array(
                'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                'post_route' => URL::to('channel/livestream/store') ,
                'button_text' => 'Add New Video',
                // 'admin_user' => Auth::user(),
                'video_categories' => LiveCategory::all() ,
                'languages' => Language::all() ,
                'category_id' => [],
                'languages_id' => [],
                'liveStreamVideo_error' => '0',
                'Rtmp_urls' => RTMP::all() ,
                'InappPurchase' => InappPurchase::all() ,
                'compress_image_settings' => $compress_image_settings,
            );
            return View::make('channel.livestream.create_edit', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function Channelstore(Request $request)
    {

        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {

            $user = Session::get('channel');
            $user_id = $user->id;

            $data = $request->all();

            // dd($data);
            $validatedData = $request->validate([
            // 'title' => 'required|max:255',
            // 'slug' => 'required|max:255',
            // 'description' => 'required',
            // 'details' => 'required|max:255',
            // 'year' => 'required'
            ]);
            if (!empty($data['video_category_id']))
            {
                $category_id = $data['video_category_id'];
                unset($data['video_category_id']);
            }
            if (!empty($data['language']))
            {
                $languagedata = $data['language'];
                unset($data['language']);
            }
            $image = (isset($data['image'])) ? $data['image'] : '';
            $mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';

            $data['mp4_url'] = $request->get('mp4_url');

            $path = public_path() . '/uploads/livecategory/';

            $image_path = public_path() . '/uploads/images/';

            if ($image != '')
            {
                //code for remove old file
                if ($image != '' && $image != null)
                {
                    $file_old = $image_path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $image;
                //   $data['image']  = $file->getClientOriginalName();
                $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

                $file->move($image_path, $data['image']);

            }

            $player_image = ($request->file('player_image')) ? $request->file('player_image') : '';

            $path = public_path() . '/uploads/livecategory/';
            $image_path = public_path() . '/uploads/images/';

            if ($player_image != '')
            {
                //code for remove old file
                if ($player_image != '' && $player_image != null)
                {
                    $file_old = $image_path . $player_image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $player_image = $player_image;
                //    $data['player_image']  = $player_image->getClientOriginalName();
                $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName());

                $player_image->move($image_path, $data['player_image']);
                //    $player_image  = $player_image->getClientOriginalName();
                $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());

            }
            else
            {
                $player_image = "default_horizontal_image.jpg";
            }

            // $data['user_id'] = Auth::user()->id;
            //        unset($data['tags']);
            if (empty($data['active']))
            {
                $data['active'] = 0;
            }

            if (empty($data['mp4_url']))
            {
                $data['mp4_url'] = 0;
            }
            else
            {
                $data['mp4_url'] = $data['mp4_url'];
            }

            if (empty($data['year']))
            {
                $data['year'] = 0;
            }
            else
            {
                $data['year'] = $data['year'];
            }

            if (empty($data['id']))
            {
                $data['id'] = 0;
            }

            if (empty($data['featured']))
            {
                $data['featured'] = 0;
            }

            if (empty($data['status']))
            {
                $data['status'] = 0;
            }
            if (empty($data['banner']))
            {
                $data['banner'] = 0;
            }
            if (empty($data['ppv_price']))
            {
                $data['ppv_price'] = null;
            }
            if (empty($data['access']))
            {
                $data['access'] = 0;
            }
            if (empty($data['publish_time']))
            {
                $data['publish_time'] = 0;
            }
            if (isset($data['duration']))
            {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }

            $ppv_price = null;
        
            if (empty($data['ppv_price'])) {
                $settings = Setting::where('ppv_status', 1)->first();
                if (!empty($settings)) {
                    $ppv_price = $settings->ppv_price;
                }
            } else {
                $ppv_price = $data['ppv_price'];
            }

            $last_id = LiveStream::latest()->pluck('id')->first() + 1;

            if(  $data['slug']  == ''){
    
                $slug = LiveStream::where('slug',$data['title'])->first();
                $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$last_id) ;
            }else{
    
                $slug = LiveStream::where('slug',$data['slug'])->first();
                $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$last_id) ;
            }

            if (empty($data['embed_url']))
            {
                $embed_url = null;
            }
            else
            {
                $embed_url = $data['embed_url'];
            }
            if (empty($data['url_type']))
            {
                $url_type = null;
            }
            else
            {
                $url_type = $data['url_type'];
            }
            if (empty($data['mp4_url']))
            {
                $mp4_url = null;
            }
            else
            {
                $mp4_url = $data['mp4_url'];
            }
            $movie = new LiveStream;

            // live stream video
            if (!empty($data['live_stream_video']))
            {

                $live_stream_video = $data['live_stream_video'];
                $live_stream_videopath = URL::to('public/uploads/LiveStream/');
                $LiveStream_Video = time() . '_' . $live_stream_video->getClientOriginalName();
                $live_stream_video->move(public_path('uploads/LiveStream/') , $LiveStream_Video);
                $live_video_name = strtok($LiveStream_Video, '.');
                $M3u8_save_path = $live_stream_videopath . '/' . $live_video_name . '.m3u8';

                $ffmpeg = \Streaming\FFMpeg::create();
                $videos = $ffmpeg->open('public/uploads/LiveStream' . '/' . $LiveStream_Video);

                $r_144p = (new Representation)->setKiloBitrate(95)
                    ->setResize(256, 144);
                $r_240p = (new Representation)->setKiloBitrate(150)
                    ->setResize(426, 240);
                $r_360p = (new Representation)->setKiloBitrate(276)
                    ->setResize(640, 360);
                $r_480p = (new Representation)->setKiloBitrate(750)
                    ->setResize(854, 480);
                $r_720p = (new Representation)->setKiloBitrate(2048)
                    ->setResize(1280, 720);
                $r_1080p = (new Representation)->setKiloBitrate(4096)
                    ->setResize(1920, 1080);

                $videos->hls()
                    ->x264()
                    ->addRepresentations([$r_144p, $r_360p, $r_480p, $r_720p])->save('public/uploads/LiveStream' . '/' . $live_video_name . '.m3u8');

                $movie->live_stream_video = $M3u8_save_path;
            }

            if (!empty($data['url_type']) && $data['url_type'] == "Encode_video")
            {
                $Stream_key = random_int(1000000000, 9999999999);
                $movie->Stream_key = $Stream_key;
                $movie->Rtmp_url = $data['Rtmp_url'];
            }
            
            // dd( $ppv_price);

            $movie->uploaded_by = 'Channel';
            $movie->title = $data['title'];
            $movie->embed_url = $embed_url;
            $movie->url_type = $url_type;
            $movie->details = $data['details'];
            // $movie->video_category_id =$data['video_category_id'];
            $movie->description = $data['description'];
            $movie->featured = $data['featured'];
            // $movie->language =$data['language'];
            $movie->banner = $data['banner'];
            $movie->duration = $data['duration'];
            $movie->ppv_price = $ppv_price;
            $movie->access = $data['access'];
            $movie->publish_type = $data['publish_type'];
            $movie->publish_time = $data['publish_time'];
            // $movie->footer =$data['footer'];
            $movie->slug = $data['slug'];
            $movie->image = $file->getClientOriginalName();
            $movie->mp4_url = $data['mp4_url'];
            $movie->year = $data['year'];
            $movie->active = 0;
            $movie->player_image = $player_image;
            $movie->user_id = $user_id;
            $movie->uploaded_by = 'Channel';
            $movie->ios_ppv_price = $request->ios_ppv_price;
            $movie->search_tags = !empty($request->searchtags) ? $request->searchtags : null ;
            $movie->save();

            // $movie = LiveStream::create($data);
            $shortcodes = $request['short_code'];
            $languages = $request['language'];

            if (!empty($category_id))
            {
                CategoryLive::where('live_id', $movie->id)
                    ->delete();
                foreach ($category_id as $key => $value)
                {
                    $category = new CategoryLive;
                    $category->live_id = $movie->id;
                    $category->category_id = $value;
                    $category->save();
                }

            }

            /*save LiveLanguage*/
            if (!empty($language_id))
            {
                LiveLanguage::where('live_id', $movie->id)
                    ->delete();
                foreach ($language_id as $key => $value)
                {
                    $serieslanguage = new LiveLanguage;
                    $serieslanguage->live_id = $movie->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }

            }
            $settings = Setting::first();
            $user = Session::get('channel'); 
            $user_id = $user->id;
            $Channel = Channel::where('id', $user_id)->first();
            try {
    
                $email_template_subject =  EmailTemplate::where('id',11)->pluck('heading')->first() ;
                $email_subject  = str_replace("{ContentName}", "$movie->title", $email_template_subject);
    
                $data = array(
                    'email_subject' => $email_subject,
                );
    
                Mail::send('emails.Channel_Partner_Content_Pending', array(
                    'Name'         => $Channel->channel_name,
                    'ContentName'  =>  $movie->title,
                    'AdminApprovalLink' => "",
                    'website_name' => GetWebsiteName(),
                    'UploadMessage'  => 'A Live Stream has been Uploaded into Portal',
                ), 
                function($message) use ($data,$Channel) {
                    $message->from(AdminMail(),GetWebsiteName());
                    $message->to($Channel->email, $Channel->channel_name)->subject($data['email_subject']);
                });
    
                $email_log      = 'Mail Sent Successfully from Partner Channel Audio Successfully Uploaded & Awaiting Approval !';
                $email_template = "44";
                $user_id = $user_id;
    
                Email_sent_log($user_id,$email_log,$email_template);
    
        } catch (\Throwable $th) {
    
            $email_log = $th->getMessage();
            $email_template = "44";
            $user_id = $user_id;
    
            Email_notsent_log($user_id, $email_log, $email_template);
        }    
            if (!empty($data['url_type']) && $data['url_type'] == "Encode_video")
            {
                return Redirect::to('channel/livestream')->with(['Stream_key' => $Stream_key, 'Stream_error' => '1', 'Rtmp_url' => $data['Rtmp_url'], 'title' => $data['title']]);
            }
            else
            {
                return Redirect::to('channel/livestream')->with(array(
                    'message' => 'New PPV Video Successfully Added!',
                    'note_type' => 'success'
                ));
            }

        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function createSlug($title, $id = 0)
    {

        $slug = Str::slug($title);

        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug))
        {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1;$i <= 10;$i++)
        {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug))
            {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return LiveStream::select('slug')->where('slug', 'like', $slug . '%')->where('id', '<>', $id)->get();
    }

    public function Channeledit($id)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            $video = LiveStream::find($id);

            $Stream_key = Session::get('Stream_key');
            $Stream_error = Session::get('Stream_error');
            $Rtmp_url = Session::get('Rtmp_url');
            $title = Session::get('title');

            $compress_image_settings = CompressImage::first();

            $data = array(
                'headline' => '<i class="fa fa-edit"></i> Edit Video',
                'video' => $video,
                'post_route' => URL::to('channel/livestream/update') ,
                'button_text' => 'Update Video',
                // 'admin_user' => Auth::user(),
                'video_categories' => LiveCategory::all() ,
                'languages' => Language::all() ,
                'category_id' => CategoryLive::where('live_id', $id)->pluck('category_id')
                    ->toArray() ,
                'languages_id' => LiveLanguage::where('live_id', $id)->pluck('language_id')
                    ->toArray() ,
                'liveStreamVideo_error' => '0',
                'settings' => Setting::first() ,
                'Stream_key' => $Stream_key,
                'Stream_error' => $Stream_error ? $Stream_error : 0,
                'Settings' => Setting::first() ,
                'Rtmp_url' => $Rtmp_url ? $Rtmp_url : null,
                'title' => $title ? $title : null,
                'Rtmp_urls' => RTMP::all() ,
                'InappPurchase' => InappPurchase::all() ,
                'compress_image_settings' => $compress_image_settings,
            );

            return View::make('channel.livestream.edit', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function Channeldestroy($id)
    {
        //  LiveStream::
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            // destroy($id);
            LiveStream::destroy($id);

            return Redirect::back();
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }
    public function Channelupdate(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            $data = $request->all();
            $id = $data['id'];
            $video = LiveStream::findOrFail($id);
            $validatedData = $request->validate([
            // 'title' => 'required|max:255',
            // 'slug' => 'required|max:255',
            // 'description' => 'required',
            // 'details' => 'required|max:255',
            // 'year' => 'required'
            ]);

            $image = ($request->file('image')) ? $request->file('image') : '';
            $mp4_url = (isset($data['mp4_url'])) ? $data['mp4_url'] : '';

            if (empty($data['active']))
            {
                $data['active'] = 0;
            }

            if (empty($data['ppv_status']))
            {
                $data['ppv_status'] = 0;
            }
           
            if(  $data['slug']  == '' ){

                $slug = LiveStream::whereNotIn('id',[$id])->where('slug',$data['title'])->first();

                $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
            }else{

                $slug = LiveStream::whereNotIn('id',[$id])->where('slug',$data['slug'])->first();

                $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$id) ;
            }

            if (empty($data['rating']))
            {
                $data['rating'] = 0;
            }

            if (empty($data['year']))
            {
                $data['year'] = 0;
            }

            if (empty($data['featured']))
            {
                $data['featured'] = 0;
            }

            if (empty($data['status']))
            {
                $data['status'] = 0;
            }

            if (empty($data['type']))
            {
                $data['type'] = '';
            }

            $path = public_path() . '/uploads/livecategory/';
            $image_path = public_path() . '/uploads/images/';

            if ($image != '')
            {
                //code for remove old file
                if ($image != '' && $image != null)
                {
                    $file_old = $image_path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $image;
                //   $data['image']  = $file->getClientOriginalName();
                $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

                $file->move($image_path, $data['image']);

            }

            $player_image = ($request->file('player_image')) ? $request->file('player_image') : '';

            $path = public_path() . '/uploads/livecategory/';
            $image_path = public_path() . '/uploads/images/';

            if ($player_image != '')
            {
                //code for remove old file
                if ($player_image != '' && $player_image != null)
                {
                    $file_old = $image_path . $player_image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $player_image = $player_image;
                //    $data['player_image']  = $player_image->getClientOriginalName();
                $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName());

                $player_image->move($image_path, $data['player_image']);
                //    $player_image  = $player_image->getClientOriginalName();
                $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());

            }
            else
            {
                $player_image = $video->player_image;
            }

            $data['mp4_url'] = $request->get('mp4_url');

            if (isset($data['duration']))
            {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }

            if (empty($data['embed_url']))
            {
                $embed_url = null;
            }
            else
            {
                $embed_url = $data['embed_url'];
            }
            if (empty($data['url_type']))
            {
                $url_type = null;
            }
            else
            {
                $url_type = $data['url_type'];
            }
            if ($data['access'] == "ppv")
            {
                $ppv_price = $data['ppv_price'];
            }
            else
            {
                // dd($data);
                $ppv_price = null;
            }
            $shortcodes = $request['short_code'];
            $languages = $request['language'];
            //  $data['ppv_price'] = $request['ppv_price'];
            $data['access'] = $request['access'];
            $data['active'] = 1;

            // Live Stream Video
            if (!empty($data['url_type']) && $data['url_type'] == "live_stream_video" && !empty($data['live_stream_video']))
            {

                $live_stream_video = $data['live_stream_video'];
                $live_stream_videopath = URL::to('public/uploads/LiveStream/');
                $LiveStream_Video = time() . '_' . $live_stream_video->getClientOriginalName();
                $live_stream_video->move(public_path('uploads/LiveStream/') , $LiveStream_Video);
                $live_video_name = strtok($LiveStream_Video, '.');
                $M3u8_save_path = $live_stream_videopath . '/' . $live_video_name . '.m3u8';

                $ffmpeg = \Streaming\FFMpeg::create();
                $videos = $ffmpeg->open('public/uploads/LiveStream' . '/' . $LiveStream_Video);

                $r_144p = (new Representation)->setKiloBitrate(95)
                    ->setResize(256, 144);
                $r_240p = (new Representation)->setKiloBitrate(150)
                    ->setResize(426, 240);
                $r_360p = (new Representation)->setKiloBitrate(276)
                    ->setResize(640, 360);
                $r_480p = (new Representation)->setKiloBitrate(750)
                    ->setResize(854, 480);
                $r_720p = (new Representation)->setKiloBitrate(2048)
                    ->setResize(1280, 720);
                $r_1080p = (new Representation)->setKiloBitrate(4096)
                    ->setResize(1920, 1080);

                $videos->hls()
                    ->x264()
                    ->addRepresentations([$r_144p, $r_360p, $r_720p])->save('public/uploads/LiveStream' . '/' . $live_video_name . '.m3u8');

                $video->live_stream_video = $M3u8_save_path;

            }

            // video Encoder
            if (!empty($data['url_type']) && $video['url_type'] != "Encode_video" && $data['url_type'] == "Encode_video")
            {
                $Stream_key = random_int(1000000000, 9999999999);
                $video->Stream_key = $Stream_key;
            }

            if (!empty($data['url_type']) && $data['url_type'] == "Encode_video")
            {
                if ($data['Rtmp_url'] != null)
                {
                    $video->Rtmp_url = $data['Rtmp_url'];
                }
            }

            $video->update($data);
            $video->embed_url = $embed_url;
            $video->url_type = $url_type;
            $video->access = $data['access'];
            $video->ppv_price = $ppv_price;
            $video->player_image = $player_image;
            $video->publish_status = $request['publish_status'];
            $video->publish_type = $request['publish_type'];
            $video->publish_time = $request['publish_time'];
            $video->user_id = $user_id;
            $video->ios_ppv_price = $request->ios_ppv_price;
            $video->search_tags = !empty($data['searchtags']) ? $data['searchtags'] : null ;
            $video->save();

            if (!empty($data['video_category_id']))
            {
                $category_id = $data['video_category_id'];
                unset($data['video_category_id']);
                /*save artist*/
                if (!empty($category_id))
                {
                    CategoryLive::where('live_id', $video->id)
                        ->delete();
                    foreach ($category_id as $key => $value)
                    {
                        $category = new CategoryLive;
                        $category->live_id = $video->id;
                        $category->category_id = $value;
                        $category->save();
                    }

                }
            }
            if (!empty($data['language']))
            {
                $language_id = $data['language'];
                unset($data['language']);
                /*save artist*/
                if (!empty($language_id))
                {
                    LiveLanguage::where('live_id', $video->id)
                        ->delete();
                    foreach ($language_id as $key => $value)
                    {
                        $serieslanguage = new LiveLanguage;
                        $serieslanguage->live_id = $video->id;
                        $serieslanguage->language_id = $value;
                        $serieslanguage->save();
                    }

                }
            }

            if (!empty($data['url_type']) && $video['url_type'] == "Encode_video" && $data['url_type'] == "Encode_video")
            {

                return Redirect::to('channel/livestream/edit' . '/' . $id)->with(['Stream_key' => $video['Stream_key'], 'Stream_error' => '1', 'Rtmp_url' => $data['Rtmp_url'] ? $data['Rtmp_url'] : $video['rtmp_url'], 'title' => $data['title']]);
            }
            else
            {

                return Redirect::to('channel/livestream/edit' . '/' . $id)->with(array(
                    'message' => 'Successfully Updated Video!',
                    'note_type' => 'success'
                ));
            }

        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function ChannelLiveVideosIndex()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {

            // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
            $videos = LiveStream::where('active', '=', 0)->join('moderators_users', 'moderators_users.id', '=', 'live_streams.user_id')
                ->select('moderators_users.username', 'live_streams.*')
                ->orderBy('live_streams.created_at', 'DESC')
                ->paginate(9);
            // dd($videos);
            $data = array(
                'videos' => $videos,
            );

            return View('channel.livestream.livevideoapproval.live_video_approval', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }
    public function ChannelLiveVideosApproval($id)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $video = LiveStream::findOrFail($id);
            $video->active = 1;
            $video->save();
            return Redirect::back()
                ->with('message', 'Your video will be available shortly after we process it');
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function ChannelLiveVideosReject($id)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $video = LiveStream::findOrFail($id);
            $video->active = 2;
            $video->save();
            return Redirect::back()
                ->with('message', 'Your video will be available shortly after we process it');
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

}

