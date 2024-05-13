<?php
namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Test as Test;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Setting as Setting;
use App\Menu as Menu;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use App\Audio as Audio;
use App\AudioCategory as AudioCategory;
use App\Page as Page;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Audioartist;
use App\AudioAlbums;
use DB;
use Session;
use App\CategoryAudio;
use App\AudioLanguage;
use App\InappPurchase;
use App\Channel;
use App\EmailTemplate;
use Mail;
use App\SiteTheme;
use App\ChannelSubscription;

class ChannelAudioController extends Controller
{


    public function __construct()
    {
        $this->enable_channel_Monetization = SiteTheme::pluck('enable_channel_Monetization')->first();
    }

    public function Channelindex(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            $search_value = $request->get('s');

            if (!empty($search_value)):
                $audios = Audio::where('title', 'LIKE', '%' . $search_value . '%')->where('user_id', '=', $id)->where('uploaded_by', 'Channel')
                    ->orderBy('created_at', 'desc')
                    ->paginate(9);
            else:
                $audios = Audio::orderBy('created_at', 'DESC')->where('user_id', '=', $user_id)->where('uploaded_by', 'Channel')
                    ->paginate(9);
            endif;

            // $user = Auth::user();
            $data = array(
                'audios' => $audios,
                'user' => $user,
            );

            return View::make('channel.audios.index', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    /**
     * Show the form for creating a new audio
     *
     * @return Response
     */
    public function Channelcreate()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
           
            $user_id = $user->id;

            if($this->enable_channel_Monetization == 1){

                $ChannelSubscription = ChannelSubscription::where('user_id', '=', $user_id)->count(); 
                    
                if($ChannelSubscription == 0 ){

                    return View::make('channel.becomeSubscriber');

                }elseif($ChannelSubscription > 0){

                    $ChannelSubscription = ChannelSubscription::where('channel_subscriptions.user_id', '=', $user_id)->orderBy('channel_subscriptions.created_at', 'DESC')
                                            ->join('channel_subscription_plans', 'channel_subscription_plans.plan_id', '=', 'channel_subscriptions.stripe_plan')
                                            ->first(); 

                    if( !empty($ChannelSubscription) ){

                        $upload_audio_limit = $ChannelSubscription->upload_audio_limit;
                        $uploaded_Audios = Audio::where('uploaded_by','Channel')->where('user_id', '=', $user_id)->count();
                        if($upload_audio_limit != null){
                            if($upload_audio_limit <= $uploaded_Audios){
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

            $settings = Setting::first();

            $data = array(
                'headline' => '<i class="fa fa-plus-circle"></i> New Audio',
                'post_route' => URL::to('channel/audios/audioupdate') ,
                'button_text' => 'Add New Audio',
                // 'admin_user' => Auth::user(),
                'languages' => Language::all() ,
                'audio_categories' => AudioCategory::all() ,
                'audio_albums' => AudioAlbums::all() ,
                'artists' => Artist::all() ,
                'audio_artist' => [],
                'category_id' => [],
                'languages_id' => [],
                'settings' => $settings,
                'InappPurchase' => InappPurchase::all() ,

            );
            return View::make('channel.audios.create_edit', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }
    // 'post_route' => URL::to('admin/audios/store'),
    

    
    /**
     * Store a newly created audio in storage.
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
            $validator = Validator::make($data = $request->all() , Audio::$rules);

            if ($validator->fails())
            {
                return Redirect::back()
                    ->withErrors($validator)->withInput();
            }
            /*Slug*/
            if ($request->slug != '')
            {
                $data['slug'] = $this->createSlug($request->slug);
            }

            if ($request->slug == '')
            {
                $data['slug'] = $this->createSlug($data['title']);
            }
            $data['user_id'] = $user_id;
            if (!empty($data['artists']))
            {
                $artistsdata = $data['artists'];
                unset($data['artists']);
            }
            $path = public_path() . '/uploads/audios/';
            $image_path = public_path() . '/uploads/images/';
            $image = (isset($data['image'])) ? $data['image'] : '';
            if (!empty($image))
            {
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
            else
            {
                $data['image'] = 'placeholder.jpg';
            }

            if (empty($data['active']))
            {
                $data['active'] = 0;
            }

            if (empty($data['featured']))
            {
                $data['featured'] = 0;
            }

            if (isset($data['duration']))
            {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }

            $audio = Audio::create($data);
            $audio_id = $audio->id;

            if (!empty($artistsdata))
            {
                foreach ($artistsdata as $key => $value)
                {
                    $artist = new Audioartist;
                    $artist->audio_id = $audio_id;
                    $artist->artist_id = $value;
                    $artist->save();
                }

            }

            $audio_upload = $request->file('audio_upload');
            $ext = $audio_upload->extension();

            if ($audio_upload)
            {
                if ($ext == 'mp3')
                {
                    $audio_upload->move('public/uploads/audios/', $audio->id . '.' . $ext);

                    $data['mp3_url'] = URL::to('/') . '/public/uploads/audios/' . $audio->id . '.' . $ext;
                }
                else
                {
                    $audio_upload->move(storage_path() . '/app/', $audio_upload->getClientOriginalName());

                    FFMpeg::open($audio_upload->getClientOriginalName())
                        ->export()
                        ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                        ->toDisk('public')
                        ->save('audios/' . $audio->id . '.mp3');
                    unlink(storage_path() . '/app/' . $audio_upload->getClientOriginalName());
                    $data['mp3_url'] = URL::to('/') . '/public/uploads/audios/' . $audio->id . '.mp3';

                }

                $update_url = Audio::find($audio_id);

                $update_url->mp3_url = $data['mp3_url'];

                $update_url->search_tags = !empty($request->searchtags) ? $request->searchtags : null ;

                $update_url->save();
            }

            return Redirect::back()
                ->with(array(
                'message' => 'New Audio Successfully Added!',
                'note_type' => 'success'
            ));
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    /**
     * Show the form for editing the specified audio.
     *
     * @param  int  $id
     * @return Response
     */
    public function Channeledit($id)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            $audio = Audio::find($id);
            $settings = Setting::first();

            $data = array(
                'headline' => '<i class="fa fa-edit"></i> Edit Audio',
                'audio' => $audio,
                'post_route' => URL::to('/channel/audios/update') ,
                'button_text' => 'Update Audio',
                // 'admin_user' => Auth::user(),
                'languages' => Language::all() ,
                'audio_categories' => AudioCategory::all() ,
                'audio_albums' => AudioAlbums::all() ,
                'artists' => Artist::all() ,
                'audio_artist' => Audioartist::where('audio_id', $id)->pluck('artist_id')
                    ->toArray() ,
                'category_id' => CategoryAudio::where('audio_id', $id)->pluck('category_id')
                    ->toArray() ,
                'languages_id' => AudioLanguage::where('audio_id', $id)->pluck('language_id')
                    ->toArray() ,
                'settings' => $settings,
                'InappPurchase' => InappPurchase::all() ,
            );

            return View::make('channel.audios.edit', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function Channelupdate(Request $request)
    {

        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            $input = $request->all();
            $id = $request->id;
            $audio = Audio::findOrFail($id);

            $validator = Validator::make($data = $input, Audio::$rules);

            if ($validator->fails())
            {
                return Redirect::back()
                    ->withErrors($validator)->withInput();
            }

            $data['ppv_price'] = $request->ppv_price;
            $data['ios_ppv_price'] = $request->ios_ppv_price;


            if(  $data['slug']  == '' || $audio->slug == '' ){

                $slug = Audio::where('slug',$data['title'])->first();
    
                $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
            }else{
    
                $slug = Audio::where('slug',$data['slug'])->first();
    
                $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$id) ;
            }
            

            if (isset($data['duration']))
            {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }
            $path = public_path() . '/uploads/audios/';
            $image_path = public_path() . '/uploads/images/';
            if (empty($data['image']))
            {
                unset($data['image']);
            }
            else
            {
                $image = $data['image'];
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

            $path = public_path() . '/uploads/audios/';
            $image_path = public_path() . '/uploads/images/';
            if (empty($data['player_image']))
            {
                $player_image = "default_horizontal_image.jpg";
            }
            else
            {
                $image = $data['player_image'];
                if ($image != '' && $image != null)
                {
                    $file_old = $image_path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $player_image = $image;
                //   $data['player_image']  = $player_image->getClientOriginalName();
                $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName());

                $player_image->move($image_path, $data['player_image']);
                // $player_image =  $player_image->getClientOriginalName();
                $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());

            }

            if (empty($data['active']))
            {
                $data['active'] = 0;
            }

            if (empty($data['featured']))
            {
                $data['featured'] = 0;
            }
            $data['user_id'] = $user_id;

            $audio->search_tags = !empty($request->searchtags) ? $request->searchtags : null ;
            $audio->update($data);
            $audio->player_image = $player_image;

            if (!empty($data['artists']))
            {
                $artistsdata = $data['artists'];
                unset($data['artists']);
                /*save artist*/
                if (!empty($artistsdata))
                {
                    Audioartist::where('audio_id', $id)->delete();
                    foreach ($artistsdata as $key => $value)
                    {
                        $artist = new Audioartist;
                        $artist->audio_id = $id;
                        $artist->artist_id = $value;
                        $artist->save();
                    }

                }
            }
            if (!empty($data['audio_category_id']))
            {
                $category_id = $data['audio_category_id'];
                unset($data['audio_category_id']);
                /*save artist*/
                if (!empty($category_id))
                {
                    CategoryAudio::where('audio_id', $audio->id)
                        ->delete();
                    foreach ($category_id as $key => $value)
                    {
                        $category = new CategoryAudio;
                        $category->audio_id = $audio->id;
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
                    AudioLanguage::where('audio_id', $audio->id)
                        ->delete();
                    foreach ($language_id as $key => $value)
                    {
                        $serieslanguage = new AudioLanguage;
                        $serieslanguage->audio_id = $audio->id;
                        $serieslanguage->language_id = $value;
                        $serieslanguage->save();
                    }

                }
            }

            if (empty($data['audio_upload']))
            {
                unset($data['audio_upload']);
            }
            else
            {

                $audio_upload = $request->file('audio_upload');
                $ext = $audio_upload->extension();

                if ($audio_upload)
                {
                    if ($ext == 'mp3')
                    {
                        $audio_upload->move('public/uploads/audios/', $audio->id . '.' . $ext);

                        $data['mp3_url'] = URL::to('/') . '/public/uploads/audios/' . $audio->id . '.' . $ext;
                    }
                    else
                    {
                        $audio_upload->move(storage_path() . '/app/', $audio_upload->getClientOriginalName());

                        FFMpeg::open($audio_upload->getClientOriginalName())
                            ->export()
                            ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                            ->toDisk('public')
                            ->save('audios/' . $audio->id . '.mp3');
                        unlink(storage_path() . '/app/' . $audio_upload->getClientOriginalName());
                        $data['mp3_url'] = URL::to('/') . '/public/uploads/audios/' . $audio->id . '.mp3';

                    }

                    $update_url = Audio::find($audio->id);

                    $update_url->mp3_url = $data['mp3_url'];

                    $update_url->save();

                }

            }

            return Redirect::back()
                ->with(array(
                'message' => 'Successfully Updated Audio!',
                'note_type' => 'success'
            ));
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function Channeldestroy($id)
    {

        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $audio = Audio::find($id);

            // $this->deleteAudioImages($audio);
            Audio::destroy($id);

            Audioartist::where('audio_id', $id)->delete();

            return Redirect::back()
                ->with(array(
                'message' => 'Successfully Deleted Audio',
                'note_type' => 'success'
            ));
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }

    private function ChanneldeleteAudioImages($audio)
    {
        $ext = pathinfo($audio->image, PATHINFO_EXTENSION);
        if (file_exists(public_path() . '/uploads/images/' . $audio->image) && $audio->image != 'placeholder.jpg')
        {
            @unlink(public_path() . '/uploads/images/' . $audio->image);
        }

        if (file_exists(public_path() . '/uploads/images/' . str_replace('.' . $ext, '-large.' . $ext, $audio->image)) && $audio->image != 'placeholder.jpg')
        {
            @unlink(public_path() . '/uploads/images/' . str_replace('.' . $ext, '-large.' . $ext, $audio->image));
        }

        if (file_exists(public_path() . '/uploads/images/' . str_replace('.' . $ext, '-medium.' . $ext, $audio->image)) && $audio->image != 'placeholder.jpg')
        {
            @unlink(public_path() . '/uploads/images/' . str_replace('.' . $ext, '-medium.' . $ext, $audio->image));
        }

        if (file_exists(public_path() . '/uploads/images/' . str_replace('.' . $ext, '-small.' . $ext, $audio->image)) && $audio->image != 'placeholder.jpg')
        {
            @unlink(public_path() . '/uploads/images/' . str_replace('.' . $ext, '-small.' . $ext, $audio->image));
        }
    }

    public function ChannelcreateSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
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

    protected function ChannelgetRelatedSlugs($slug, $id = 0)
    {
        return Audio::select('slug')->where('slug', 'like', $slug . '%')->where('id', '<>', $id)->get();
    }
    public function ChannelAudiofile(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;


            if($this->enable_channel_Monetization == 1){

                $ChannelSubscription = ChannelSubscription::where('user_id', '=', $user_id)->count(); 
                    
                if($ChannelSubscription == 0 ){
    
                    $value = [];
                    $value['total_uploads'] = 0;
                    return $value;
    
                }elseif($ChannelSubscription > 0){
    
                    $ChannelSubscription = ChannelSubscription::where('channel_subscriptions.user_id', '=', $user_id)->orderBy('channel_subscriptions.created_at', 'DESC')
                                            ->join('channel_subscription_plans', 'channel_subscription_plans.plan_id', '=', 'channel_subscriptions.stripe_plan')
                                            ->first(); 
    
                    if( !empty($ChannelSubscription) ){
    
                        $upload_audio_limit = $ChannelSubscription->upload_audio_limit;
                        $uploaded_Audios = Audio::where('uploaded_by','Channel')->where('user_id', '=', $user_id)->count();
                        
                        if($upload_audio_limit != null){
                            if($upload_audio_limit <= $uploaded_Audios){
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                            }
                        }

                    }else{
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                    }
                    
                }else{
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                }
            }

            $audio = new Audio();
            $audio->mp3_url = $request['mp3'];
            $audio->user_id = $user_id;
            $audio->uploaded_by = 'Channel';
            $audio->save();
            $audio_id = $audio->id;

            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['audio_id'] = $audio_id;
            return $value;
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }
    public function ChanneluploadAudio(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            
            if($this->enable_channel_Monetization == 1){

                $ChannelSubscription = ChannelSubscription::where('user_id', '=', $user_id)->count(); 
                    
                if($ChannelSubscription == 0 ){
    
                    $value = [];
                    $value['total_uploads'] = 0;
                    return $value;
    
                }elseif($ChannelSubscription > 0){
    
                    $ChannelSubscription = ChannelSubscription::where('channel_subscriptions.user_id', '=', $user_id)->orderBy('channel_subscriptions.created_at', 'DESC')
                                            ->join('channel_subscription_plans', 'channel_subscription_plans.plan_id', '=', 'channel_subscriptions.stripe_plan')
                                            ->first(); 
    
                    if( !empty($ChannelSubscription) ){
    
                        $upload_audio_limit = $ChannelSubscription->upload_audio_limit;
                        $uploaded_Audios = Audio::where('uploaded_by','Channel')->where('user_id', '=', $user_id)->count();
                        
                        if($upload_audio_limit != null){
                            if($upload_audio_limit <= $uploaded_Audios){
                                $value = [];
                                $value['total_uploads'] = 0;
                                return $value;
                            }
                        }
    
                    }else{
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                    }
                    
                }else{
                            $value = [];
                            $value['total_uploads'] = 0;
                            return $value;
                }
            }
            
            $audio_upload = $request->file('file');
            $ext = $audio_upload->extension();

            $file = $request
                ->file
                ->getClientOriginalName();
            // print_r($file);exit();
            $newfile = explode(".mp4", $file);
            $mp3titile = $newfile[0];

            $audio = new Audio();
            // $audio->disk = 'public';
            $audio->title = $mp3titile;
            $audio->save();
            $audio_id = $audio->id;

            if ($audio_upload)
            {

                if ($ext == 'mp3')
                {

                    $audio_upload->move('public/uploads/audios/', $audio->id . '.' . $ext);

                    $data['mp3_url'] = URL::to('/') . '/public/uploads/audios/' . $audio->id . '.' . $ext;
                }
                else
                {
                    $audio_upload->move(storage_path() . '/app/', $audio_upload->getClientOriginalName());
                    echo "<pre>";
                    print_r($audio_upload);
                    exit();
                    FFMpeg::open($audio_upload->getClientOriginalName())
                        ->export()
                        ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                        ->toDisk('public')
                        ->save('audios/' . $audio->id . '.mp3');
                    unlink(storage_path() . '/app/' . $audio_upload->getClientOriginalName());
                    $data['mp3_url'] = URL::to('/') . '/public/uploads/audios/' . $audio->id . '.mp3';

                }
                $update_url = Audio::find($audio_id);
                $title = $update_url->title;
                //   $update_url = Audio::find($audio_id);
                $update_url->mp3_url = $data['mp3_url'];
                $update_url->user_id = $user_id;
                $update_url->uploaded_by = 'Channel';
                $update_url->save();

                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['audio_id'] = $audio_id;
                $value['user_id'] = $user_id;
                $value['title'] = $title;

                return $value;

            }

            else
            {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.';
                // $video = Video::create($data);
                return response()->json($value);

            }
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }
    public function Channelaudioupdate(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = Session::get('channel');
            $user_id = $user->id;
            $input = $request->all();
            $data = $request->all();

            $id = $request->audio_id;

            $audio = Audio::findOrFail($id);
            // dd($input);
            

            /*Slug*/
            if(  $data['slug']  == '' || $audio->slug == ''){

                $slug = Audio::whereNotIn('id',[$id])->where('slug',$data['title'])->first();
    
                $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
            }else{
    
                $slug = Audio::whereNotIn('id',[$id])->where('slug',$data['slug'])->first();
    
                $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$id) ;
            }
    
            if (isset($data['duration']))
            {
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
            }
            $path = public_path() . '/uploads/audios/';
            $image_path = public_path() . '/uploads/images/';
            if (empty($data['image']))
            {
                unset($data['image']);
            }
            else
            {
                $image = $data['image'];
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

            $path = public_path() . '/uploads/audios/';
            $image_path = public_path() . '/uploads/images/';
            if (empty($data['player_image']))
            {
                $player_image = "default_horizontal_image.jpg";
            }
            else
            {
                $image = $data['player_image'];
                if ($image != '' && $image != null)
                {
                    $file_old = $image_path . $image;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $player_image = $image;
                //   $data['player_image']  = $player_image->getClientOriginalName();
                $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName());

                $player_image->move($image_path, $data['player_image']);
                // $player_image =  $player_image->getClientOriginalName();
                $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());

            }

            if ($audio->active == 0)
            {
                $data['active'] = 0;
            }
            else
            {
                $data['active'] = 1;
            }

            if (empty($data['featured']))
            {
                $data['featured'] = 0;
            }
            $data['user_id'] = $user_id;

            $data['draft'] = 1;

            $data['ppv_price'] = $input['ppv_price'];
            $data['ios_ppv_price'] = $input['ios_ppv_price'];

            $audio->update($data);
            $audio->player_image = $player_image;

            $audio = Audio::findOrFail($id);

            if (!empty($data['artists']))
            {
                $artistsdata = $data['artists'];
                unset($data['artists']);
                /*save artist*/
                if (!empty($artistsdata))
                {
                    Audioartist::where('audio_id', $id)->delete();
                    foreach ($artistsdata as $key => $value)
                    {
                        $artist = new Audioartist;
                        $artist->audio_id = $id;
                        $artist->artist_id = $value;
                        $artist->save();
                    }

                }
            }

            if (!empty($data['audio_category_id']))
            {
                $category_id = $data['audio_category_id'];
                unset($data['audio_category_id']);
                /*save artist*/
                if (!empty($category_id))
                {
                    CategoryAudio::where('audio_id', $audio->id)
                        ->delete();
                    foreach ($category_id as $key => $value)
                    {
                        $category = new CategoryAudio;
                        $category->audio_id = $audio->id;
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
                    AudioLanguage::where('audio_id', $audio->id)
                        ->delete();
                    foreach ($language_id as $key => $value)
                    {
                        $serieslanguage = new AudioLanguage;
                        $serieslanguage->audio_id = $audio->id;
                        $serieslanguage->language_id = $value;
                        $serieslanguage->save();
                    }

                }
            }
            $settings = Setting::first();
            $user = Session::get('channel'); 
    
            $user_id = $user->id;
            $Channel = Channel::where('id', $user_id)->first();
            try {
    
                $email_template_subject =  EmailTemplate::where('id',11)->pluck('heading')->first() ;
                $email_subject  = str_replace("{ContentName}", "$audio->title", $email_template_subject);
    
                $data = array(
                    'email_subject' => $email_subject,
                );
    
                Mail::send('emails.Channel_Partner_Content_Pending', array(
                    'Name'         => $Channel->channel_name,
                    'ContentName'  =>  $audio->title,
                    'AdminApprovalLink' => "",
                    'website_name' => GetWebsiteName(),
                    'UploadMessage'  => 'A Audio has been Uploaded into Portal',
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
            return Redirect::back()
            ->with('message', 'Content has been Submitted for Approval ');
        }
        else
        {
            return Redirect::to('/blocked');
        }

    }
}

