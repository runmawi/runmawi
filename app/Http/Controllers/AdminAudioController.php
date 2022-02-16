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
use App\SystemSetting as SystemSetting;
use Session;
use App\CountryCode;
use App\BlockAudio;
use App\CategoryAudio;
use App\AudioLanguage;




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
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;

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
        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;
        $countries=CountryCode::all();

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
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
            );
         
        return View::make('admin.audios.create_edit', $data);
    }else if($package == "Basic"){

        return view('blocked');

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
        if (!empty($data['password_hash'])) {
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
              $data['image']  = $file->getClientOriginalName();
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

        if (!empty($data['password_hash'])) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;

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
            );

        return View::make('admin.audios.edit', $data);
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
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */


    public function update(Request $request)
    {
        $data = Session::all();
        if (!empty($data['password_hash'])) {
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
        if ($audio->slug != $request->slug) {
            $data['slug'] = $this->createSlug($request->slug, $id);
        }

        if($request->slug == '' || $audio->slug == ''){
            $data['slug'] = $this->createSlug($data['title']);    
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
        } else {
            $image = $data['image'];
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
              $data['image']  = $file->getClientOriginalName();
              $file->move($image_path, $data['image']);
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
        $data['ppv_status'] = 1;
        }
        $audio->update($data);
        $audio->ppv_price =  $ppv_price;
        $audio->ppv_status =  $data['ppv_status'];
        $audio->save();

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
        if(empty($data['audio_upload'])){
            unset($data['audio_upload']);
        } else {
        
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

            $update_url = Audio::find($audio->id);

            $update_url->mp3_url = $data['mp3_url'];

            $update_url->save();  


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
        if (!empty($data['password_hash'])) {
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
    public function uploadAudio(Request $request)
    {

        $audio_upload = $request->file('file');
        $ext = $audio_upload->extension();
               
          
                $file = $request->file->getClientOriginalName();
                // print_r($file);exit();
        
                $newfile = explode(".mp4",$file);
                $mp3titile = $newfile[0];

                $audio = new Audio();
                // $audio->disk = 'public';
                $audio->title = $mp3titile;
                $audio->save(); 
                $audio_id = $audio->id;

                if($audio_upload) {
   
                    if($ext == 'mp3'){
                     
                        $audio_upload->move('public/uploads/audios/', $audio->id.'.'.$ext);
        
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.'.$ext; 
                    }else{
                        $audio_upload->move(storage_path().'/app/', $audio_upload->getClientOriginalName());
                        // echo "<pre>";
                        // print_r($audio_upload);
                        // exit();  
                        FFMpeg::open($audio_upload->getClientOriginalName())
                        ->export()
                        ->inFormat(new \FFMpeg\Format\Audio\Mp3)
                        ->toDisk('public')
                        ->save('audios/'. $audio->id.'.mp3');
                        unlink(storage_path().'/app/'.$audio_upload->getClientOriginalName());
                        $data['mp3_url'] = URL::to('/').'/public/uploads/audios/'.$audio->id.'.mp3'; 
        
                     
                     
                    }  
                    $update_url = Audio::find($audio_id);
                    $title =$update_url->title; 
                  //   $update_url = Audio::find($audio_id);

                    $update_url->mp3_url = $data['mp3_url'];
        
                    $update_url->save();  
             
                     $value['success'] = 1;
                     $value['message'] = 'Uploaded Successfully!';
                     $value['audio_id'] = $audio_id;
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
        // echo"<pre>";
        // print_r($input);
        // exit();
        // dd($settings);

        $settings =Setting::first();
        if(!empty($input['ppv_price'])){
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
        /*Slug*/
        if ($audio->slug != $request->slug) {
            $data['slug'] = $this->createSlug($request->slug, $id);
        }

        if($request->slug == '' || $audio->slug == ''){
            $data['slug'] = $this->createSlug($data['title']);    
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
        } else {
            $image = $data['image'];
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
              $data['image']  = $file->getClientOriginalName();
              $file->move($image_path, $data['image']);
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
        $data['ppv_status'] = 1;
        }
        $audio->update($data);
        $audio->ppv_price =  $ppv_price;
        $audio->status =  1;
        $audio->ppv_status =  $data['ppv_status'];
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
        return Redirect::back();
    }
}
