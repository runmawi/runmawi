<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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
use App\SystemSetting as SystemSetting;
use Session;
use App\CountryCode;
use App\BlockAudio;
use App\CategoryAudio;
use App\AudioLanguage;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\InappPurchase;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\StorageSetting as StorageSetting;


class AdminAudioController extends Controller
{
   /**
     * Display a listing of audios
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = Session::all();
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
      $search_value = $request->get('s');
        
        if(!empty($search_value)):
            $audios = Audio::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $audios = Audio::orderBy('created_at', 'DESC')->paginate(9);
        endif;
        
        $user = Auth::user();

        $data = array(
            'audios' => $audios,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.audios.index', $data);
    }else if($package == "Basic"){

        return view('blocked');

    }
}
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
    }
    

    /**
     * Show the form for creating a new audio
     *
     * @return Response
     */
    public function create()
    {
        $data = Session::all();
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;
        $countries=CountryCode::all();
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

            $StorageSetting = StorageSetting::first();
            // dd($StorageSetting);
            if($StorageSetting->site_storage == 1){
                $dropzone_url =  URL::to('admin/uploadAudio');
            }elseif($StorageSetting->aws_storage == 1){
                $dropzone_url =  URL::to('admin/AWSUploadAudio');
            }else{ 
                $dropzone_url =  URL::to('admin/uploadAudio');
            }

        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Audio',
            'post_route' => URL::to('admin/audios/audioupdate'),
            'button_text' => 'Add New Audio',
            'admin_user' => Auth::user(),
            'languages' => Language::all(),
            'audio_categories' => AudioCategory::all(),
            'audio_albums' => AudioAlbums::all(),
            'artists' => Artist::all(),
            'audio_artist' => [],
            'countries' => $countries,
            'settings' => Setting::first(),
            'category_id' => [],
            'languages_id' => [],
            'InappPurchase' => InappPurchase::all(),
            'dropzone_url' => $dropzone_url,
            );
         
        return View::make('admin.audios.create_edit', $data);
    }else if($package == "Basic"){

        return view('blocked');

    }
}
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
        // 'post_route' => URL::to('admin/audios/store'),

    }

    /**
     * Store a newly created audio in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = Session::all();
        // dd($data);
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
        $validator = Validator::make($data = $request->all(), Audio::$rules);
        
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
         /*Slug*/
        if ($request->slug != '') {
            $data['slug'] = $this->createSlug($request->slug);
        }

        if($request->slug == ''){
            $data['slug'] = $this->createSlug($data['title']);    
        }
        $data['user_id'] = Auth::user()->id;    
        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
        }
        if(!empty($data['audio_category_id'])){
            $category_id = $data['audio_category_id'];
            unset($data['audio_category_id']);
        }
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);
        }
        $path = public_path().'/uploads/audios/';
        $image_path = public_path().'/uploads/images/';
        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
            //   $data['image']  = $file->getClientOriginalName();
              $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());
              $file->move($image_path, $data['image']);
        } else {
            $data['image'] = 'placeholder.jpg';
        }
        

        
        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        $audio = Audio::create($data);
        $audio_id = $audio->id;

        if(!empty($artistsdata)){
            foreach ($artistsdata as $key => $value) {
                $artist = new Audioartist;
                $artist->audio_id = $audio_id;
                $artist->artist_id = $value;
                $artist->save();
            }
            
        }
       
    
        
        $audio_upload = $request->file('audio_upload');
        $ext = $audio_upload->extension();
        
        if($audio_upload){
            if($ext == 'mp3'){
                $audio_upload->move('public/uploads/audios/', $audio->id.'.'.$ext);

                $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.'.$ext; 
            }else{
                $audio_upload->move(storage_path().'/app/', $audio_upload->getClientOriginalName());
                
                FFMpeg::open($audio_upload->getClientOriginalName())
                ->export()
                ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                ->toDisk('public')
                ->save('audios/'. $audio->id.'.mp3');
                unlink(storage_path().'/app/'.$audio_upload->getClientOriginalName());
                $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.mp3'; 

            }

            $update_url = Audio::find($audio_id);

            $update_url->mp3_url = $data['mp3_url'];

            $update_url->save();  
        }
       

        return Redirect::to('admin/audios')->with(array('message' => 'New Audio Successfully Added!', 'note_type' => 'success') );
    }else if($package == "Basic"){

        return view('blocked');

    }
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
    }

    /**
     * Show the form for editing the specified audio.
     *
     * @param  int  $id
     * @return Response
     */
     public function edit($id)
    {
        $data = Session::all();
        $countries=CountryCode::all();

        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else{
        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
        $audio = Audio::find($id);
        // dd(AudioLanguage::where('audio_id', $id)->pluck('language_id')->toArray());
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Audio',
            'audio' => $audio,
            'post_route' => URL::to('admin/audios/update'),
            'button_text' => 'Update Audio',
            'admin_user' => Auth::user(),
            'languages' => Language::all(),
            'audio_categories' => AudioCategory::all(),
            'audio_albums' => AudioAlbums::all(),
            'artists' => Artist::all(),
            'settings' => Setting::first(),
            'audio_artist' => Audioartist::where('audio_id', $id)->pluck('artist_id')->toArray(),
            'countries' => $countries,
            'category_id' => CategoryAudio::where('audio_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => AudioLanguage::where('audio_id', $id)->pluck('language_id')->toArray(),
            'InappPurchase' => InappPurchase::all(),
            );

        return View::make('admin.audios.edit', $data);
    }else if($package == "Basic"){

        return view('blocked');

    }
}
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */


    public function update(Request $request)
    {

        $data = Session::all();

        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package =    User::where('id', $package_id)->first();
            $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
         
            $input = $request->all();
            $id = $request->id;
            $settings =Setting::first();
            if(!empty($input['ppv_price'])){
                $ppv_price = $input['ppv_price'];
            }elseif($input['ppv_status'] || $settings->ppv_status == 1){
                $ppv_price = $settings->ppv_price;
            }

            $audio = Audio::findOrFail($id);

            $validator = Validator::make($data = $input, Audio::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator)->withInput();
            }

        /*Slug*/

        if(  $data['slug']  == '' || $audio->slug == ''){

            $slug = Audio::whereNotIn('id',[$id])->where('slug',$data['title'])->first();

            $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
        }else{

            $slug = Audio::whereNotIn('id',[$id])->where('slug',$data['slug'])->first();

            $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$id) ;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        $path = public_path().'/uploads/audios/';
        $image_path = public_path().'/uploads/images/';

        if(empty($data['image'])){
            unset($data['image']);
        } 
        else {
            $image = $data['image'];
            
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
            }

            if(compress_image_enable() == 1){

                $audio_filename  = time().'.'.compress_image_format();
                $audio_image     =  'audio_'.$audio_filename ;
                Image::make($image)->save(base_path().'/public/uploads/images/'.$audio_image,compress_image_resolution() );
            }else{

                $audio_filename  = time().'.'.$audio_image->getClientOriginalExtension();
                $audio_image     =  'audio_'.$audio_filename ;
                Image::make($image)->save(base_path().'/public/uploads/images/'.$audio_image );
            }  

            $data['image'] = $audio_image ;
        }

       
        if(empty($data['player_image'])){
            unset($data['player_image']);
                $player_image = $audio->player_image;
        } 
        else {
            $image = $data['player_image'];

                if($image != ''  && $image != null){
                    $file_old = $image_path.$image;
                    if (file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                $player_image = $image;

                if(compress_image_enable() == 1){

                    $audio_player_filename  = time().'.'.compress_image_format();
                    $audio_player_image     =  'audio_player_'.$audio_player_filename ;
                    Image::make($image)->save(base_path().'/public/uploads/images/'.$audio_player_image,compress_image_resolution() );
                }else{
    
                    $audio_player_filename  = time().'.'.$audio_player_image->getClientOriginalExtension();
                    $audio_player_image     =  'audio_player_'.$audio_player_filename ;
                    Image::make($image)->save(base_path().'/public/uploads/images/'.$audio_player_image );
                }  

                $player_image = $audio_player_image;
        }

        if(empty($data['active'])){
            $data['active'] = 0;
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        if(empty($data['ppv_status'])){
            $status = 0;
        }else{
        $status = 1;
        }

        if(!empty($data['searchtags'])){
            $searchtags = $data['searchtags'];
        }else{
            $searchtags = null;
        }

        if(!empty($data['banner'])){
            $banner = $data['banner'];
        }else{
            $banner = 0;
        }

        $audio->update($data);
        $audio->ppv_price =  $ppv_price;
        $audio->ppv_status =  $data['ppv_status'];
        $audio->search_tags =  $searchtags;
        $audio->banner =  $banner;
        $audio->ios_ppv_price =  $request->ios_ppv_price;
        $audio->player_image =  $player_image;
        $audio->status =  $status;
        $audio->save();
        // dd($audio->id);

        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
            /*save artist*/
            if(!empty($artistsdata)){
                Audioartist::where('audio_id', $id)->delete();
                foreach ($artistsdata as $key => $value) {
                    $artist = new Audioartist;
                    $artist->audio_id = $id;
                    $artist->artist_id = $value;
                    $artist->save();
                }

            }
        }

        if(!empty($input['country'])){
            $country = $input['country'];
            unset($input['country']);
            /*save country*/
            if(!empty($country)){
                BlockAudio::where('audio_id',$id)->delete();
                foreach ($country as $key => $value) {
                    $country = new BlockAudio;
                    $country->audio_id = $id;
                    $country->country = $value;
                    $country->save();
                }

            }
        }

 if(!empty($data['audio_category_id'])){
            $category_id = $data['audio_category_id'];
            unset($data['audio_category_id']);
            /*save artist*/
            if(!empty($category_id)){
                CategoryAudio::where('audio_id', $audio->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryAudio;
                    $category->audio_id = $audio->id;
                    $category->category_id = $value;
                    $category->save();
                }

            }
        }
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);
            /*save artist*/
            if(!empty($language_id)){
                AudioLanguage::where('audio_id', $audio->id)->delete();
                foreach ($language_id as $key => $value) {
                    $serieslanguage = new AudioLanguage;
                    $serieslanguage->audio_id = $audio->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }

            }
        }
            // dd($input);

            $StorageSetting = StorageSetting::first();

            if($StorageSetting->site_storage == 1){

                if(empty($data['audio_upload'])){
                    unset($data['audio_upload']);
                } else {
                
                $audio_upload = $request->file('audio_upload');
                $ext = $audio_upload->extension();
                
                if($audio_upload){
                    if($ext == 'mp3'){
                       $audio_store = $audio_upload->move('public/uploads/audios/', $audio->id.'.'.$ext);
        
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.'.$ext; 
        
                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info($audio_store, true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
        
                    }else{
                        $audio_upload->move(storage_path().'/app/', $audio_upload->getClientOriginalName());
                        
                        FFMpeg::open($audio_upload->getClientOriginalName())
                        ->export()
                        ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                        ->toDisk('public')
                        ->save('audios/'. $audio->id.'.mp3');
                        unlink(storage_path().'/app/'.$audio_upload->getClientOriginalName());
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.mp3'; 
        
                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info(storage_path().'/app/public/audios/'.$audio->id. '.mp3', true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
        
                    }
        
                    $update_url = Audio::find($audio->id);
        
                    $update_url->mp3_url = $data['mp3_url'];
                    $update_url->duration =  $audio_duration_time;
                    $update_url->save();  
                }
        
                }
        
            }elseif($StorageSetting->aws_storage == 1){

                $file = $request->file('audio_upload');
                // $name = time() . $file->getClientOriginalName();
                $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                // print_r($file);exit;
                $filePath = $StorageSetting->aws_audio_path.'/'. $name;
                
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $audio = $path.$filePath;
                
                $data['mp3_url'] = $audio; 
    
                $audio_duration = new \wapmorgan\Mp3Info\Mp3Info($file, true);
                $audio_duration_time = round( $audio_duration->duration,2 ) ;

                $update_url = Audio::find($audio->id);
        
                $update_url->mp3_url = $data['mp3_url'];
                $update_url->duration =  $audio_duration_time;
                $update_url->save();  

            }else{ 
                if(empty($data['audio_upload'])){
                    unset($data['audio_upload']);
                } else {
                
                $audio_upload = $request->file('audio_upload');
                $ext = $audio_upload->extension();
                
                if($audio_upload){
                    if($ext == 'mp3'){
                       $audio_store = $audio_upload->move('public/uploads/audios/', $audio->id.'.'.$ext);
        
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.'.$ext; 
        
                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info($audio_store, true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
        
                    }else{
                        $audio_upload->move(storage_path().'/app/', $audio_upload->getClientOriginalName());
                        
                        FFMpeg::open($audio_upload->getClientOriginalName())
                        ->export()
                        ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                        ->toDisk('public')
                        ->save('audios/'. $audio->id.'.mp3');
                        unlink(storage_path().'/app/'.$audio_upload->getClientOriginalName());
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.mp3'; 
        
                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info(storage_path().'/app/public/audios/'.$audio->id. '.mp3', true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
        
                    }
        
                    $update_url = Audio::find($audio->id);
        
                    $update_url->mp3_url = $data['mp3_url'];
                    $update_url->duration =  $audio_duration_time;
                    $update_url->save();  
                }
        
                }
            }

        return Redirect::to('admin/audios/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Audio!', 'note_type' => 'success') );
    }else if($package == "Basic"){

        return view('blocked');
    }
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = Session::all();
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
            
        $audio = Audio::find($id);

        $this->deleteAudioImages($audio);

        Audio::destroy($id);

        Audioartist::where('audio_id',$id)->delete();

        return Redirect::to('admin/audios')->with(array('message' => 'Successfully Deleted Audio', 'note_type' => 'success') );
    }else if($package == "Basic"){

        return view('blocked');

    }
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
}


    private function deleteAudioImages($audio){
        $ext = pathinfo($audio->image, PATHINFO_EXTENSION);
        if(file_exists(public_path().'/uploads/images/' . $audio->image) && $audio->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/images/' . $audio->image);
        }

        if(file_exists(public_path().'/uploads/images/' . str_replace('.' . $ext, '-large.' . $ext, $audio->image) )  && $audio->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/images/' . str_replace('.' . $ext, '-large.' . $ext, $audio->image) );
        }

        if(file_exists(public_path().'/uploads/images/' . str_replace('.' . $ext, '-medium.' . $ext, $audio->image) )  && $audio->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/images/' . str_replace('.' . $ext, '-medium.' . $ext, $audio->image) );
        }

        if(file_exists(public_path().'/uploads/images/' . str_replace('.' . $ext, '-small.' . $ext, $audio->image) )  && $audio->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/images/' . str_replace('.' . $ext, '-small.' . $ext, $audio->image) );
        }
    }

    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Audio::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
    public function Audiofile(Request $request)
    {
        
    $audio = new Audio();
    $audio->mp3_url = $request['mp3'];
    $audio->save(); 
    $audio_id = $audio->id;

    $value['success'] = 1;
    $value['message'] = 'Uploaded Successfully!';
    $value['audio_id'] = $audio_id;
    return $value;  

    }            
    public function AudioLivefile(Request $request)
    {
        
    $audio = new Audio();
    $audio->mp3_url = $request['mp3'];
    $audio->type = 'live_mp3';
    $audio->save(); 
    $audio_id = $audio->id;

    $value['success'] = 1;
    $value['message'] = 'Uploaded Successfully!';
    $value['audio_id'] = $audio_id;
    return $value;  

    }           
    public function uploadAudio(Request $request)
    {

        $audio_upload = $request->file('file');
        $ext = $audio_upload->extension();
               
        // $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());
          
                $file = $request->file->getClientOriginalName();
    
                $newfile = explode(".mp4",$file);
                $mp3titile = $newfile[0];

                $audio = new Audio();
                // $audio->disk = 'public';
                $audio->title = $mp3titile;
                $audio->image = 'default_image.jpg';

                $audio->save(); 
                $audio_id = $audio->id;

                if($audio_upload) {
   
                    if($ext == 'mp3'){
                     
                        $audio_store = $audio_upload->move('public/uploads/audios/', $audio->id.'.'.$ext);
        
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.'.$ext; 

                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info($audio_store, true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
                    }else{
                        
                        $audio_upload->move(storage_path().'/app/', $audio_upload->getClientOriginalName());

                        FFMpeg::open($audio_upload->getClientOriginalName())
                                    ->export()
                                    ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                                    ->toDisk('public')
                                    ->save('audios/'. $audio->id.'.mp3');

                        unlink(storage_path().'/app/'.$audio_upload->getClientOriginalName());

                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.mp3'; 

                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info(storage_path().'/app/public/audios/'.$audio->id. '.mp3', true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
                    }  
                    $update_url = Audio::find($audio_id);
                    $title =$update_url->title; 
                  //   $update_url = Audio::find($audio_id);

                    $update_url->mp3_url = $data['mp3_url'];
                    $update_url->duration = $audio_duration_time;
                    $update_url->save();  
             
                     $value['success'] = 1;
                     $value['message'] = 'Uploaded Successfully!';
                     $value['audio_id'] = $audio_id;
                     $value['audio_duration_time'] =  gmdate('H:i:s', $audio_duration_time);
                     $value['title'] = $title;
             
                     return $value;  
            
                    }
                    
                    else {
                     $value['success'] = 2;
                     $value['message'] = 'File not uploaded.'; 
                        // $video = Video::create($data);
                    return response()->json($value);
                    
                    }

    }
    public function audioupdate(Request $request)
    {
    
        $input = $request->all();

        $id = $request->audio_id;

        $settings =Setting::first();
            if(!empty($input['ppv_price'])){
                $ppv_price = $input['ppv_price'];
            }elseif(!empty($input['ppv_status']) || $settings->ppv_status == 1){
                $ppv_price = $settings->ppv_price;
            }

            if(!empty($input['searchtags'])){
                $ppv_price = $input['ppv_price'];
            }elseif(!empty($input['ppv_status']) || $settings->ppv_status == 1){
                $ppv_price = $settings->ppv_price;
            }

        $audio = Audio::findOrFail($id);

        $validator = Validator::make($data = $input, Audio::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            if(  $data['slug']  == ''){

                $slug = Audio::where('slug',$data['title'])->first();
    
                $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
            }else{
    
                $slug = Audio::where('slug',$data['slug'])->first();
    
                $data['slug'] = $slug == null ?  str_replace(' ', '_', $data['slug']) : str_replace(' ', '_', $data['slug'].'-'.$id) ;
            }


      
        $path = public_path().'/uploads/audios/';
        $image_path = public_path().'/uploads/images/';

        if(empty($data['image'])){
            unset($data['image']);
        } 
        else {
            $image = $data['image'];

            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              
            $file = $image;
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName()); //upload new file
            $file->move($image_path, $data['image']);
        }


        if(empty($data['player_image'])){
            $player_image = "default_horizontal_image.jpg";
        } 
        else {
            $image = $data['player_image'];
            
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              
            $player_image = $image; //upload new file
            $data['player_image'] = str_replace(' ', '_', $player_image->getClientOriginalName()); 
            $player_image->move($image_path, $data['player_image']);
            $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        if(empty($data['banner'])){
            $data['banner'] = 0;
        }

        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
            $data['ppv_status'] = 1;
        }


        if(!empty($input['searchtags'])){
            $searchtags = $input['searchtags'];
        }else{
            $searchtags = null;
        }

        if(isset($input['duration'])){
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $input['duration']);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['duration'] = $time_seconds;
        }

        $audio->update($data);
        $audio->ppv_price =  $ppv_price;
        $audio->player_image =  $player_image;
        $audio->search_tags =  $searchtags;
        $audio->status =  1;
        $audio->ppv_status =  $data['ppv_status'];
        $audio->ios_ppv_price =  $data['ios_ppv_price'];
        $audio->save();

        $audio = Audio::findOrFail($id);
        $users = User::all();
        if($audio['draft'] == 1){
            foreach ($users as $key => $user) {
                $userid[]= $user->id;
           // send_password_notification('Notification From FLICKNEXS','New Videp Added','',$user->id);
            }
            foreach ($userid as $key => $user_id) {
          send_password_notification('Notification From FLICKNEXS','New Audio Added','',$user_id);
           }
       }
        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
            /*save artist*/
            if(!empty($artistsdata)){
                Audioartist::where('audio_id', $id)->delete();
                foreach ($artistsdata as $key => $value) {
                    $artist = new Audioartist;
                    $artist->audio_id = $id;
                    $artist->artist_id = $value;
                    $artist->save();
                }

            }
        }
        if(!empty($data['audio_category_id'])){
            $category_id = $data['audio_category_id'];
            unset($data['audio_category_id']);
            /*save artist*/
            if(!empty($category_id)){
                CategoryAudio::where('audio_id', $audio->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new CategoryAudio;
                    $category->audio_id = $audio->id;
                    $category->category_id = $value;
                    $category->save();
                }

            }
        }
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);
            /*save artist*/
            if(!empty($language_id)){
                AudioLanguage::where('audio_id', $audio->id)->delete();
                foreach ($language_id as $key => $value) {
                    $serieslanguage = new AudioLanguage;
                    $serieslanguage->audio_id = $audio->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }

            }
        }

        if(!empty($input['country'])){
            $country = $input['country'];
            unset($input['country']);
            /*save country*/
            if(!empty($country)){
                BlockAudio::where('audio_id',$id)->delete();
                foreach ($country as $key => $value) {
                    $country = new BlockAudio;
                    $country->audio_id = $id;
                    $country->country = $value;
                    $country->save();
                }

            }
        }

        return Redirect::to('admin/audios/create')->with(array('message' => 'New Audio Successfully Added!', 'note_type' => 'success') );
    }


    public function AWSUploadAudio(Request $request)
    {

        $audio_upload = $request->file('file');
        $ext = $audio_upload->extension();
        $StorageSetting = StorageSetting::first();

        // $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());
                $file = $request->file->getClientOriginalName();
    
                $newfile = explode(".mp4",$file);
                $mp3titile = $newfile[0];

                $audio = new Audio();
                // $audio->disk = 'public';
                $audio->title = $mp3titile;
                $audio->image = 'default_image.jpg';

                $audio->save(); 
                $audio_id = $audio->id;

                if($audio_upload) {
   
                    if($ext == 'mp3'){


                        $file = $request->file('file');
                        // $name = time() . $request->file->getClientOriginalName();
                        $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                        // print_r($file);exit;
                        $filePath = $StorageSetting->aws_audio_path.'/'. $name;
                        
                        Storage::disk('s3')->put($filePath, file_get_contents($file));
                        $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                        $audio = $path.$filePath;
                        
                        $data['mp3_url'] = $audio; 

                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info($audio_upload, true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
                    }else{
                        
                        $file = $request->file('file');
                        // $name = time() . $request->file->getClientOriginalName();
                        $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                  
                        Storage::disk('s3')->put($filePath, file_get_contents($file));
                        $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                        $audio = $path.$filePath;


                        // FFMpeg::open($file->getClientOriginalName())
                        //             ->export()
                        //             ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                        //             ->toDisk('public')
                        //             ->save('audios/'. $audio->id.'.mp3');

                        // unlink(storage_path().'/app/'.$audio_upload->getClientOriginalName());

                        $data['mp3_url'] = $audio; 

                        $audio_duration = new \wapmorgan\Mp3Info\Mp3Info($audio_upload, true);
                        $audio_duration_time = round( $audio_duration->duration,2 ) ;
                    }  
                    $update_url = Audio::find($audio_id);
                    $title =$update_url->title; 
                  //   $update_url = Audio::find($audio_id);

                    $update_url->mp3_url = $data['mp3_url'];
                    $update_url->duration = $audio_duration_time;
                    $update_url->save();  
             
                     $value['success'] = 1;
                     $value['message'] = 'Uploaded Successfully!';
                     $value['audio_id'] = $audio_id;
                     $value['audio_duration_time'] =  gmdate('H:i:s', $audio_duration_time);
                     $value['title'] = $title;
             
                     return $value;  
            
                    }
                    
                    else {
                     $value['success'] = 2;
                     $value['message'] = 'File not uploaded.'; 
                        // $video = Video::create($data);
                    return response()->json($value);
                    
                    }

    }

    public function Audios_bulk_delete( Request $request )
    {
         try {
            $audio_id = $request->audio_id;

            Audio::whereIn("id", explode(",", $audio_id))->delete();

            return response()->json(["message" => "true"]);
        } 
        catch (\Throwable $th) {
            return response()->json(["message" => "false"]);
        }
    }

}
