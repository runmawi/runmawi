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
use App\Geofencing;
use App\RecentView;
use App\BlockAudio;
use App\Favorite;
use App\Wishlist;
use App\Watchlater;
use App\PpvPurchase;
use Carbon\Carbon;
use App\ModeratorsUser;
use App\EmailTemplate;
use Mail;
use Maatwebsite\Excel\Facades\Excel;

class CPPAdminAudioController extends Controller
{
   /**
     * Display a listing of audios
     *
     * @return Response
     */
    public function CPPindex(Request $request)
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $id = $user->id;
      $search_value = $request->get('s');
        
        if(!empty($search_value)):
            $audios = Audio::where('title', 'LIKE', '%'.$search_value.'%')->where('user_id','=',$id)->orderBy('created_at', 'desc')->paginate(9);
        else:
            $audios = Audio::orderBy('created_at', 'DESC')->where('user_id','=',$id)->get();
        endif;
        
        // $user = Auth::user();

        $data = array(
            'audios' => $audios,
            // 'user' => $user,
            );

        return View::make('moderator.cpp.audios.index', $data);
    }else{
        return Redirect::to('/blocked');
      }

    }
    

    /**
     * Show the form for creating a new audio
     *
     * @return Response
     */
    public function CPPcreate()
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $id = $user->id;
        $settings = Setting::first();

        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Audio',
            'post_route' => URL::to('cpp/audios/audioupdate'),
            'button_text' => 'Add New Audio',
            // 'admin_user' => Auth::user(),
            'languages' => Language::all(),
            'audio_categories' => AudioCategory::all(),
            'audio_albums' => AudioAlbums::all(),
            'artists' => Artist::all(),
            'audio_artist' => [],
            'category_id' => [],
            'languages_id' => [],
            'settings' => $settings,
            'InappPurchase' => InappPurchase::all(),

            );
        return View::make('moderator.cpp.audios.create_edit', $data);
    }else{
        return Redirect::to('/blocked');
      }

    }
        // 'post_route' => URL::to('admin/audios/store'),

    

    /**
     * Store a newly created audio in storage.
     *
     * @return Response
     */
    public function CPPstore(Request $request)
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
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
        $data['user_id'] = $user_id;    
        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
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
       

        return Redirect::back()->with(array('message' => 'New Audio Successfully Added!', 'note_type' => 'success') );
    }else{
        return Redirect::to('/blocked');
      }

    }

    /**
     * Show the form for editing the specified audio.
     *
     * @param  int  $id
     * @return Response
     */
     public function CPPedit($id)
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $audio = Audio::find($id);
        $settings = Setting::first();
        
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Audio',
            'audio' => $audio,
            'post_route' => URL::to('/cpp/audios/update'),
            'button_text' => 'Update Audio',
            // 'admin_user' => Auth::user(),
            'languages' => Language::all(),
            'audio_categories' => AudioCategory::all(),
            'audio_albums' => AudioAlbums::all(),
            'artists' => Artist::all(),
            'audio_artist' => Audioartist::where('audio_id', $id)->pluck('artist_id')->toArray(),
            'category_id' => CategoryAudio::where('audio_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => AudioLanguage::where('audio_id', $id)->pluck('language_id')->toArray(),
            'settings' => $settings,
            'InappPurchase' => InappPurchase::all(),
            );

        return View::make('moderator.cpp.audios.edit', $data);
    }else{
        return Redirect::to('/blocked');
      }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function CPPupdate(Request $request)
    {

        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $input = $request->all();
        $id = $request->id;
        $audio = Audio::findOrFail($id);

        $validator = Validator::make($data = $input, Audio::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $lyricsFile = $request->file('lyrics');

        if ($lyricsFile) {
            $filePath = $lyricsFile->getRealPath();

            $data = Excel::toArray(null, $filePath, null, \Maatwebsite\Excel\Excel::XLSX)[0];

            $keys = [
                $data[0][0] => $data[0][0],
                $data[0][1] => $data[0][1]
            ];

            $jsonData = [];

            for ($i = 1; $i < count($data); $i++) {
                $rowData = $data[$i];

                // Validate that both "line" and "time" keys are not empty
                if (!empty($rowData[0]) && !empty($rowData[1])) {
                    // Validate that "time" is numeric
                    if (is_numeric($rowData[1]) && strpos($rowData[1], '.') === false) {
                        $jsonData[] = [
                            $keys[$data[0][0]] => $rowData[0],
                            $keys[$data[0][1]] => intval($rowData[1]),
                        ];
                    } else {
                        return Redirect::back()->with(array('error' => 'Invalid data in "time" column.', 'note_type' => 'success') );
                        // return response()->json(['error' => 'Invalid data in "time" column.']);
                    }
                } else {
                    return Redirect::back()->with(array('error' => 'Empty "line" or "time" key found.', 'note_type' => 'success') );
                    // return response()->json(['error' => 'Empty "line" or "time" key found.']);
                }
            }

            $result = [
                'lyrics' => $jsonData
            ];

            // Convert the data to JSON
            $lyrics_json = json_encode($result);
            // $data['lyrics_json'] = json_encode($result) ;

        } else {
            $lyrics_json = $audio->lyrics_json;
            // $data['lyrics_json'] = $audio->lyrics_json ;

        }
        if (!empty($lyricsFile)) {
            $lyricsFileName = str_replace(" ", "-", $lyricsFile->getClientOriginalName()) ;
            $lyricsext = $lyricsFile->extension();

            $lyrics_store = $lyricsFile->move('public/uploads/audiolyrics/', $lyricsFileName);
                    
            $lyrics = URL::to('/').'/public/uploads/audiolyrics/'.$lyricsFileName; 

        }else{
            $lyrics = $audio->lyrics ;
        }
        $data = $input;
        $data['ppv_price'] = $request->ppv_price;
        $data['ios_ppv_price'] = $request->ios_ppv_price;
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
            //   $data['image']  = $file->getClientOriginalName();
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());
              $file->move($image_path, $data['image']);
        }


        $path = public_path().'/uploads/audios/';
        $image_path = public_path().'/uploads/images/';
        if(empty($data['player_image'])){
            // unset($data['player_image']);

            // $player_image = $data['player_image'];
        } else {
            $image = $data['player_image'];
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
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

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        $data['user_id'] = $user_id;
       

        $audio->update($data);
        // $audio->player_image =  $player_image;
        $audio->uploaded_by =  'CPP';

        $audio->search_tags = !empty($request->searchtags) ? $request->searchtags : null ;
        $audio->lyrics =  $lyrics;
        $audio->lyrics_json =  $lyrics_json;
        $audio->update($data);


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


        return Redirect::back()->with(array('message' => 'Successfully Updated Audio!', 'note_type' => 'success') );
    }else{
        return Redirect::to('/blocked');
      }

}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function CPPdestroy($id)
    {

        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $audio = Audio::find($id);

        // $this->deleteAudioImages($audio);

        Audio::destroy($id);

        Audioartist::where('audio_id',$id)->delete();

        return Redirect::back()->with(array('message' => 'Successfully Deleted Audio', 'note_type' => 'success') );
    }else{
        return Redirect::to('/blocked');
      }

}


    private function CPPdeleteAudioImages($audio){
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

    public function CPPcreateSlug($title, $id = 0)
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

    protected function CPPgetRelatedSlugs($slug, $id = 0)
    {
        return Audio::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
    public function CPPAudiofile(Request $request)
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
    $audio = new Audio();
    $audio->mp3_url = $request['mp3'];
    $audio->save(); 
    $audio_id = $audio->id;

    $value['success'] = 1;
    $value['message'] = 'Uploaded Successfully!';
    $value['audio_id'] = $audio_id;
    return $value;  
}else{
    return Redirect::to('/blocked');
  }

    }                    
    public function CPPuploadAudio(Request $request)
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
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
                        echo "<pre>";
                        print_r($audio_upload);
                        exit();  
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
                     $value['user_id'] = $user_id;
                     $value['title'] = $title;
             
                     
                     return $value;  
            
                    
                  
                    }
                    
                    else {
                     $value['success'] = 2;
                     $value['message'] = 'File not uploaded.'; 
                        // $video = Video::create($data);
                    return response()->json($value);
                    
                    }
                }else{
                    return Redirect::to('/blocked');
                  }
            

    }
    public function CPPaudioupdate(Request $request)
    {
        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $input = $request->all();
      
        $id = $request->audio_id;
        // echo"<pre>";
        // print_r($id );
        // exit();
        $audio = Audio::findOrFail($id);

                     
        $lyricsFile = $request->file('lyrics');

        if ($lyricsFile) {
            $filePath = $lyricsFile->getRealPath();

            $data = Excel::toArray(null, $filePath, null, \Maatwebsite\Excel\Excel::XLSX)[0];

            $keys = [
                $data[0][0] => $data[0][0],
                $data[0][1] => $data[0][1]
            ];

            $jsonData = [];

            for ($i = 1; $i < count($data); $i++) {
                $rowData = $data[$i];

                // Validate that both "line" and "time" keys are not empty
                if (!empty($rowData[0]) && !empty($rowData[1])) {
                    // Validate that "time" is numeric
                    if (is_numeric($rowData[1]) && strpos($rowData[1], '.') === false) {
                        $jsonData[] = [
                            $keys[$data[0][0]] => $rowData[0],
                            $keys[$data[0][1]] => intval($rowData[1]),
                        ];
                    } else {
                        return Redirect::back()->with(array('error' => 'Invalid data in "time" column.', 'note_type' => 'success') );
                        // return response()->json(['error' => 'Invalid data in "time" column.']);
                    }
                } else {
                    return Redirect::back()->with(array('error' => 'Empty "line" or "time" key found.', 'note_type' => 'success') );
                    // return response()->json(['error' => 'Empty "line" or "time" key found.']);
                }
            }

            $result = [
                'lyrics' => $jsonData
            ];

            // Convert the data to JSON
            $lyrics_json = json_encode($result);
            // $data['lyrics_json'] = json_encode($result) ;

        } else {
            $lyrics_json = null;
            // $data['lyrics_json'] = $audio->lyrics_json ;

        }
        if (!empty($lyricsFile)) {
            $lyricsFileName = str_replace(" ", "-", $lyricsFile->getClientOriginalName()) ;
            $lyricsext = $lyricsFile->extension();

            $lyrics_store = $lyricsFile->move('public/uploads/audiolyrics/', $lyricsFileName);
                    
            $lyrics = URL::to('/').'/public/uploads/audiolyrics/'.$lyricsFileName; 

        }else{
            $lyrics = $audio->lyrics ;
        }

        $validator = Validator::make($data = $input, Audio::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

     
        /*Slug*/
        if(  $data['slug']  == ''){

                $slug = Audio::where('slug',$data['title'])->first();
    
                $data['slug']  = $slug == null ?  str_replace(' ', '_', $data['title']) : str_replace(' ', '_', $data['title'].'-'.$id) ;
            }else{
    
                $slug = Audio::where('slug',$data['slug'])->first();
    
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
            //   $data['image']  = $file->getClientOriginalName();
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

              $file->move($image_path, $data['image']);
        }

        $path = public_path().'/uploads/audios/';
        $image_path = public_path().'/uploads/images/';
        if(empty($data['player_image'])){
            $player_image = "default_horizontal_image.jpg";
        } else {
            $image = $data['player_image'];
            if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
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

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        $data['user_id'] = $user_id;

        $data['draft'] = 1;


        $data['ppv_price'] = $input['ppv_price'] ;
        $data['ios_ppv_price'] = $input['ios_ppv_price'] ;

        $audio->update($data);
        $audio->player_image =  $player_image;
        $audio->uploaded_by =  'CPP';
        $audio->search_tags = !empty( $input['searchtags'] ) ? $input['searchtags'] : null ;
        $audio->lyrics =  $lyrics;
        $audio->lyrics_json =  $lyrics_json;
        $audio->update($data);
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

        $settings = Setting::first();
        $user = Session::get('user'); 
        $user_id = $user->id;
        $ModeratorsUser = ModeratorsUser::where('id', $user_id)->first();
        try {

            $email_template_subject =  EmailTemplate::where('id',11)->pluck('heading')->first() ;
            $email_subject  = str_replace("{ContentName}", "$audio->title", $email_template_subject);

            $data = array(
                'email_subject' => $email_subject,
            );

            Mail::send('emails.CPP_Partner_Content_Pending', array(
                'Name'         => $ModeratorsUser->username,
                'ContentName'  =>  $audio->title,
                'AdminApprovalLink' => "",
                'website_name' => GetWebsiteName(),
                'UploadMessage'  => 'A Audio has been Uploaded into Portal',
            ), 
            function($message) use ($data,$ModeratorsUser) {
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)->subject($data['email_subject']);
            });

            $email_log      = 'Mail Sent Successfully from Partner Content Audio Successfully Uploaded & Awaiting Approval !';
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

    }else{
        return Redirect::to('/blocked');
      }

    }

    public function play_audios($slug,$name = '')
      {

        $user_package =    User::where('id', 1)->first();
        $package = $user_package->package;
        if(!empty($package) && $package== "Pro" || !empty($package) && $package == "Business" ){
        $user = Session::get('user'); 
        $user_id = $user->id;
        
        //$audio = Audio::findOrFail($albumID);
        $getfeching= Geofencing::first();
        $getfeching= Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();

        $source_id = Audio::where('slug',$slug)->pluck('id')->first();

        if (!empty($name)) {
          
             $audio = Audio::select('id')->where('slug','=',$name)->where('status','=',1)->first();
             $audio = $audio->id;
             $albumID = Audio::select('album_id')->where('slug','=',$name)->where('status','=',1)->first();
        
             $check_audio_details = Audio::where('slug','=',$name)->where('status','=',1)->first();
            
            
              if (!empty($check_audio_details)) {
                  $audio_details = Audio::where('slug','=',$name)->where('status','=',1)->first();
                } else {
                     $audio_details = Audio::where('id','=',$albumID)->where('status','=',1)->first();
                }
            
                $audio_cat_id  = Audio::select('audio_category_id')->where('album_id','=',$albumID)->where('status','=',1)->first();
        

                $audionext = Audio::select('slug')->where('id', '>', $audio)->where('album_id', '=', $albumID)->where('status','=',1)->first();

                $audioprev = Audio::where('id', '<', $audio)->where('album_id', '=', $albumID)->where('status','=',1)->first();


                  // blocked Audio
                  $block_Audio=BlockAudio::where('country',$countryName)->get();
                  if(!$block_Audio->isEmpty()){
                     foreach($block_Audio as $blocked_Audios){
                        $blocked_Audio[]=$blocked_Audios->audio_id;
                     }
                  }    
                  $blocked_Audio[]='';
                
                  $related_audio  = Audio::where('album_id','=',$albumID)->where('id','!=',$audio)->where('status','=',1);
                    if($getfeching !=null && $getfeching->geofencing == 'ON'){
                         $related_audio = $related_audio  ->whereNotIn('id',$blocked_Audio);
                  }
                   $related_audio = $related_audio ->get();

            
                $favorited = false;
                if(!empty($user_id)):
                    $favorited = Favorite::where('user_id', '=', $user_id)->where('audio_id', '=', $audio)->first();
                endif;
                $wishlisted = false;
                if(!empty($user_id)):
                    $wishlisted = Wishlist::where('user_id', '=', $user_id)->where('audio_id', '=', $audio)->first();
                endif;
                $watchlater = false;
                if(!empty($user_id)):
                    $watchlater = Watchlater::where('user_id', '=', $user_id)->where('audio_id', '=', $audio)->first();
                endif;
            
            
        } else {
           
            $audio = Audio::where('slug','=',$slug)->where('status','=',1)->first();
            if(!empty($audio)){
            $audio = $audio->id;
            }else{
            $audio = "";
            }

            $view = new RecentView;
            $view->audio_id = $audio;
            $view->user_id = $user_id;
            $view->visited_at = date('Y-m-d');
            $view->save();
             if (!empty($audio)) {
              $check_audio_details = Audio::where('id','=',$audio)->where('status','=',1)->first();
              $albumID = $check_audio_details->album_id;
                
              if (!empty($check_audio_details) && empty($name)) {
            //   echo "<pre>";dd($albumID);exit();

                  $audio_details = Audio::where('slug','=',$slug)->where('status','=',1)->first();
                   
                } else {
                     $audio_details = Audio::where('album_id','=',$albumID)->where('status','=',1)->first();
        
                }
                $audio_cat_id  = Audio::select('audio_category_id')->where('album_id','=',$albumID)->where('status','=',1)->first();
        
                $audiocurrent = Audio::select('id')->where('album_id', '=', $albumID)->where('status','=',1)->first();

                $audionext = Audio::select('slug')->where('id', '>', $audiocurrent)->where('album_id', '=', $albumID)->where('status','=',1)->first();

                $audioprev = Audio::where('id', '<', $audiocurrent)->where('album_id', '=', $albumID)->where('status','=',1)->first();

                   // blocked Audio
                   $block_Audio=BlockAudio::where('country',$countryName)->get();
                   if(!$block_Audio->isEmpty()){
                      foreach($block_Audio as $blocked_Audios){
                         $blocked_Audio[]=$blocked_Audios->audio_id;
                      }
                   }    
                   $blocked_Audio[]='';
                 
                   $related_audio  = Audio::where('album_id','=',$albumID)->where('id','!=',$audio)->where('status','=',1);
                     if($getfeching !=null && $getfeching->geofencing == 'ON'){
                          $related_audio = $related_audio  ->whereNotIn('id',$blocked_Audio);
                   }
                    $related_audio = $related_audio ->get();
 
                 
                $favorited = false;
                if(!empty($user_id)):
                    $favorited = Favorite::where('user_id', '=', $user_id)->where('audio_id', '=', $audio)->first();
                endif;
                $wishlisted = false;
                if(!empty($user_id)):
                    $wishlisted = Wishlist::where('user_id', '=', $user_id)->where('audio_id', '=', $audio)->first();
                endif;
                $watchlater = false;
                if(!empty($user_id)):
                    $watchlater = Watchlater::where('user_id', '=', $user_id)->where('audio_id', '=', $audio)->first();
                endif;
                 
             } else {
                  $data = array(
                'message' => 'No Audio Found',
                'error' =>'error',
                'json_list' => null ,
                'audios'  => null ,
                'ablum_audios' =>  null,
                'source_id'   => $source_id,  
                'user_id'   => $user_id,    
                'commentable_type' => "play_audios" ,
                );

                return View::make('moderator.cpp.audios.play_audio', $data);
            }
            
            
        }
      
            if (!empty($audio_details)) {
                $ppv_status = PpvPurchase::with('audio')->where('audio_id','=',$audio)->where('user_id','=',Auth::user()->id)->where('to_time', '>', Carbon::now())->count();
                $view_increment = $this->handleViewCount($audio); 

                $current_audio   = Audio::where('album_id',$albumID)->where('id',$audio)->get();
                $all_album_audios = Audio::where('album_id',$albumID)->get();

                $merged_audios = $current_audio->merge($all_album_audios)->all();


            $json = array('title' => $audio_details->title,'mp3'=>$audio_details->mp3_url);  
            $data = array(
                'audios' => Audio::findOrFail($audio),
                'json_list' => json_encode($json),
                'album_name' => AudioAlbums::findOrFail($albumID)->albumname,
                'album_slug' => AudioAlbums::findOrFail($albumID)->slug,
                'other_albums' => AudioAlbums::where('id','!=', $albumID)->get(),
                'audio_details' => $audio_details,
                'related_audio' => $related_audio,
                'audionext' => $audionext,
                'audioprev' => $audioprev,
                'current_slug' =>$slug,
                'url' => 'audio',
                'ppv_status' => $ppv_status,
                'view_increment' => $view_increment,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'favorited' => $favorited,
                'media_url' => URL::to('/').'/audio/'.$slug,
                'mywishlisted' => $wishlisted,
                'watchlatered' => $watchlater,
                'audio_categories' => AudioCategory::all(),
                'pages' => Page::where('active', '=', 1)->get(),
                'ablum_audios' =>  $merged_audios,
                'source_id'   => $source_id,
                'user_id'   => $user_id,    
                'commentable_type' => "play_audios" ,
                );
            } else {
                $data = array(
                'messge' => 'No Audio Found'
                );
                
            }

            return View::make('moderator.cpp.audios.play_audio', $data);
        }else{
            return Redirect::to('/blocked');
        }
    }

    public function handleViewCount($id){
        
 
        // check if this key already exists in the view_media session
        $blank_array = array();
        if (! array_key_exists($id, Session::get('viewed_audio', $blank_array) ) ) {
            
            try{
                // increment view
                $audio = Audio::find($id);
                $audio->views = $audio->views + 1;
                $audio->save();
                // Add key to the view_media session
                Session::put('viewed_audio.'.$id, time());
                return true;
            } catch (Exception $e){
                return false;
            }
        } else {
            return false;
        }
    }

}
