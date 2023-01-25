<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Audio as Audio;
use App\VideoCategory as VideoCategory;
use App\SystemSetting as SystemSetting;
use App\AudioCategory as AudioCategory;
use App\AudioAlbums as AudioAlbums;
use App\Setting as Setting;
use Auth;
use View;
use Hash;
use Illuminate\Support\Facades\Cache;
use DB;
use Session;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;

class AdminAudioCategoriesController extends Controller
{
      public function index(){
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
        $categories = AudioCategory::where('parent_id', '=', 0)->get();

        $allCategories = AudioCategory::all();
          
          
          
        $data = array (
            'allCategories'=>$allCategories,
            'categories'=>$categories,
          );
         
        return view('admin.audios.categories.index',$data);
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
    
    
     public function store(Request $request){
        $data = Session::all();
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
            $input = $request->all();
            
              $validatedData = $request->validate([
                   'name' => 'required|max:255',
             ]);
          
            $s = new AudioCategory();
           
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

            $path = public_path().'/uploads/audios/';
        
            $image = $request['image'];
            
            $slug = $request['slug']; 
          
              if ( $slug != '') {
                  $input['slug']  = $request['slug'];
              } else {
                   $input['slug']  = $request['name'];
              }

          
           if($image != '') {   
               
                if($image != ''  && $image != null){       //code for remove old file
                    $file_old = $path.$image;
                    if (file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                $file = $image;

                if(compress_image_enable() == 1){

                    $audio_categories_filename  = time().'.'.compress_image_format();
                    $audio_categories_PC_image     =  'Audio_Categories_'.$audio_categories_filename ;
                    Image::make($image)->save(base_path().'/public/uploads/audios/'.$audio_categories_PC_image,compress_image_resolution() );
                }else{

                    $audio_categories_filename  = time().'.'.$file->getClientOriginalExtension();
                    $audio_categories_PC_image     =  'Audio_Categories_'.$audio_categories_filename ;
                    Image::make($image)->save(base_path().'/public/uploads/audios/'.$audio_categories_PC_image );
                }

                $input['image']  = $audio_categories_PC_image;
            } 
            else {
               $input['image']  = 'default.jpg';
            }

            AudioCategory::create($input);

            return back()->with('message', 'New Category added successfully.');
        }else if($package == "Basic"){

            return view('blocked');
    
        } 
    }else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }                                                                                                  
       }
    
    public function edit($id){
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
            $categories = AudioCategory::where('id', '=', $id)->get();

            $allCategories = AudioCategory::all();
            return view('admin.audios.categories.edit',compact('categories','allCategories'));
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
    
    
        public function update(Request $request){

            $data = Session::all();

            if (!Auth::guest()) {

                $package_id = auth()->user()->id;
                $user_package =    User::where('id', $package_id)->first();
                $package = $user_package->package;
    
            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

                $input = $request->all();
                
                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
            
                $path = public_path().'/uploads/audios/';

                $id = $request['id'];
                $category = AudioCategory::find($id);

                if( isset($request->image) && $request->image != '') {   
                
                    if($request->image != ''  && $request->image != null){   //code for remove old file
                        $file_old = $path.$request->image;
                        if (file_exists($file_old)){
                            unlink($file_old);
                        }
                    }

                    $file = $request->image;

                    if(compress_image_enable() == 1){
    
                        $audio_categories_filename  = time().'.'.compress_image_format();
                        $audio_categories_PC_image     =  'Audio_Categories_'.$audio_categories_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/audios/'.$audio_categories_PC_image,compress_image_resolution() );
                    }else{
    
                        $audio_categories_filename  = time().'.'.$audio_categories_image->getClientOriginalExtension();
                        $audio_categories_PC_image     =  'Audio_Categories_'.$audio_categories_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/audios/'.$audio_categories_PC_image );
                    }

                    $category->image = $audio_categories_PC_image ; 
                } 
                
            
            $category->name = $request['name'];
            $category->slug = $request['slug'];
            $category->parent_id = $request['parent_id'];
            
             if ( $category->slug != '') {
              $category->slug  = $request['slug'];
              } else {
                   $category->slug  = $request['name'];
              }
            
            
            $category->save();

            return Redirect::to('admin/audios/categories')->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
                }else if($package == "Basic"){

        return view('blocked');

    }
}else{
    $system_settings = SystemSetting::first();
    $user = User::where('id','=',1)->first();
    return view('auth.login',compact('system_settings','user'));

  }
            }
    
        
    
        public function destroy($id){
            $data = Session::all();
            if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package =    User::where('id', $package_id)->first();
            $package = $user_package->package;
    
            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
                
            AudioCategory::destroy($id);
            
            $child_cats = AudioCategory::where('parent_id', '=', $id)->get();
            
            foreach($child_cats as $cats){
                $cats->parent_id = 0;
                $cats->save();
            }
            return Redirect::to('admin/audios/categories')->with(array('message' => 'Successfully Deleted Category', 'note_type' => 'success') );
        }else if($package == "Basic"){

            return view('blocked');
    
        }
    }else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }
    }
    
    
         /*Albums section */
    
    public function albumIndex(){

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
        $allAlbums = AudioAlbums::all();
        $allCategories = AudioCategory::all();
        $data = array(
            'audioCategories' => $allCategories,
            'allAlbums' => $allAlbums,
        );
        return view('admin.audios.albums.index',$data);
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

    public function storeAlbum(Request $request){

        $data = Session::all();

        if (!Auth::guest()) {

            $package_id = auth()->user()->id;
            $user_package =    User::where('id', $package_id)->first();
            $package = $user_package->package;
            
            if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
            
                $input = $request->all();

                $path = public_path().'/uploads/albums/';
                $image_path = public_path().'/uploads/albums/';

                if(empty($request['album'])){
                    unset($request['album']);
                } 
                else {
                    $image = $request['album'];
                    $audio_album_image = $request['album'];

                    if($image != ''  && $image != null){
                        $file_old = $image_path.$image;
                        if (file_exists($file_old)){
                            unlink($file_old);
                        }
                    }

                    $file = $image;

                    if(compress_image_enable() == 1){
    
                        $audio_album_filename  = time().'.'.compress_image_format();
                        $audio_album_PC_image     =  'Audio_album_'.$audio_album_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/albums/'.$audio_album_PC_image,compress_image_resolution() );
                    }else{
    
                        $audio_album_filename  = time().'.'.$audio_album_image->getClientOriginalExtension();
                        $audio_album_PC_image     =  'Audio_album_'.$audio_album_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/albums/'.$audio_album_PC_image );
                    }  

                    $input['album'] = $audio_album_PC_image ;    
                }

                 /*Slug*/
                if ($input['slug'] != '') {
                    $input['slug'] = $this->createAlbumSlug($input['slug']);
                }

                if($input['slug'] == ''){
                    $input['slug'] = $this->createAlbumSlug($input['albumname']);    
                }

                AudioAlbums::create($input);

                return back()->with('message', 'New Album added successfully.');

            }else if($package == "Basic"){
                return view('blocked');
            }

        }
        else{
            $system_settings = SystemSetting::first();
            $user = User::where('id','=',1)->first();
            return view('auth.login',compact('system_settings','user'));
        }
    }

    public function updateAlbum(Request $request){

        $data = Session::all();

        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package =    User::where('id', $package_id)->first();
            $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){
               
             $request = $request->all();
        
            $id = $request['id'];

            $audio = AudioAlbums::findOrFail($id);
        
           if ($audio->slug != $request['slug']) {
                $request['slug'] = $this->createAlbumSlug($request['slug'], $id);
            }

            if($request['slug'] == '' || $audio->slug == ''){
                $request['slug'] = $this->createAlbumSlug($request['albumname']);    
            }

            $path = public_path().'/uploads/albums/';
            $image_path = public_path().'/uploads/albums/';

            if(empty($request['album'])){
                unset($request['album']);
            } 
            else {
                $image = $request['album'];
                $audio_album_image = $request['album'];

                if($image != ''  && $image != null){
                    $file_old = $image_path.$image;

                    if (file_exists($file_old)){
                        unlink($file_old);
                    }

                    if(compress_image_enable() == 1){
    
                        $audio_album_filename  = time().'.'.compress_image_format();
                        $audio_album_PC_image     =  'Audio_album_'.$audio_album_filename ;
                        Image::make($image)->save(base_path().'/public/uploads/albums/'.$audio_album_PC_image,compress_image_resolution() );

                        $request['album']  = $audio_album_PC_image ;

                    }else{
    
                        $audio_album_filename  = time().'.'.$audio_album_image->getClientOriginalExtension();
                        $audio_album_PC_image     =  'Audio_album_'.$audio_album_filename ;
                        Image::make($image)->save(base_path().'/public/uploads/albums/'.$audio_album_PC_image );

                        $request['album']  = $audio_album_PC_image ;
                    }  
            }
         }
        
        $audio->update($request);
        
        if(isset($audio)){
            return Redirect::to('admin/audios/albums')->with(array('message' => 'Successfully Updated Albums', 'note_type' => 'success') );
        }

        }else if($package == "Basic"){

            return view('blocked');
        }

        }else{
            $system_settings = SystemSetting::first();
            $user = User::where('id','=',1)->first();
            return view('auth.login',compact('system_settings','user'));

        }
    }

    public function destroyAlbum($id){
        $data = Session::all();
        if (!Auth::guest()) {
        $package_id = auth()->user()->id;
        $user_package =    User::where('id', $package_id)->first();
        $package = $user_package->package;

        if($package == "Pro" || $package == "Business" || $package == "" && Auth::User()->role =="admin"){

        AudioAlbums::destroy($id);
       
        return Redirect::to('admin/audios/albums')->with(array('message' => 'Successfully Deleted Albums', 'note_type' => 'success') );
    }else if($package == "Basic"){

        return view('blocked');

    } 
}else{
        $system_settings = SystemSetting::first();
        $user = User::where('id','=',1)->first();
        return view('auth.login',compact('system_settings','user'));
    
      }
}

    public function editAlbum($id){
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

        $categories = AudioAlbums::where('id', '=', $id)->get();
        $allAlbums = AudioAlbums::all();
        $allCategories = AudioCategory::all();
         $data = array(
                'audioCategories' => $allCategories,
                'allAlbums' => $allAlbums,
                'categories' => $categories
            );
        
        return view('admin.audios.albums.edit',$data);
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

     public function createAlbumSlug($title, $id = 0)
            {
                // Normalize the title
                $slug = str_slug($title);

                // Get any that could possibly be related.
                // This cuts the queries down by doing it once.
                $allSlugs = $this->getRelatedAlbumSlugs($slug, $id);

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

      protected function getRelatedAlbumSlugs($slug, $id = 0)
        {
            return AudioAlbums::select('slug')->where('slug', 'like', $slug.'%')
                ->where('id', '<>', $id)
                ->get();
        }
    

}
