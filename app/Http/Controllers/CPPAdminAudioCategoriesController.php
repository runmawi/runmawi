<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Audio as Audio;
use App\VideoCategory as VideoCategory;
use App\AudioCategory as AudioCategory;
use App\AudioAlbums as AudioAlbums;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use DB;
use Session;

class CPPAdminAudioCategoriesController extends Controller
{
      public function CPPindex(){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $categories = AudioCategory::where('user_id','=',$user_id)->where('parent_id', '=', 0)->get();

        $allCategories = AudioCategory::all();
          
          
          
        $data = array (
            'allCategories'=>$allCategories,
            'categories'=>$categories,
          );
         
        return view('moderator.cpp.audios.categories.index',$data);

      }
    
    
     public function CPPstore(Request $request){
        $user = Session::get('user'); 
        $user_id = $user->id;
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
             //code for remove old file
               
              if($image != ''  && $image != null){
                   $file_old = $path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
                //upload new file
              $file = $image;
              $input['image']  = $file->getClientOriginalName();
              $file->move($path, $input['image']);
         } else {
               $input['image']  = 'default.jpg';
           }
           $input['user_id'] = $user_id;

          
            AudioCategory::create($input);
            return back()->with('message', 'New Category added successfully.');
                                                                                                
       }
    
    public function CPPedit($id){
        $user = Session::get('user'); 
        $user_id = $user->id;
            $categories = AudioCategory::where('id', '=', $id)->get();

            $allCategories = AudioCategory::all();
            return view('moderator.cpp.audios.categories.edit',compact('categories','allCategories'));

        }
    
    
        public function CPPupdate(Request $request){
            
            $user = Session::get('user'); 
            $user_id = $user->id;
            $input = $request->all();
            
             $validatedData = $request->validate([
                   'name' => 'required|max:255',
             ]);
            
            
            $path = public_path().'/uploads/audios/';

            $id = $request['id'];
            $category = AudioCategory::find($id);

             if (isset($request['image']) && !empty($request['image'])){
                $image = $request['image']; 
             } else {
                 $request['image'] = $category->image;
             }

             if( isset($image) && $image!= '') {   
              //code for remove old file
                  if($image != ''  && $image != null){
                       $file_old = $path.$image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  //upload new file
                  $file = $image;
                  $category->image  = $file->getClientOriginalName();
                  $file->move($path,$category->image);

             } 

            
            
            $category->name = $request['name'];
            $category->slug = $request['slug'];
            $category->parent_id = $request['parent_id'];
            
             if ( $category->slug != '') {
              $category->slug  = $request['slug'];
              } else {
                   $category->slug  = $request['name'];
              }
            
               $category->user_id = $user_id;
            
            $category->save();

            return Redirect::back()->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );

            }
    
        
    
        public function CPPdestroy($id){
            $user = Session::get('user'); 
            $user_id = $user->id;
                
            AudioCategory::destroy($id);
            
            $child_cats = AudioCategory::where('parent_id', '=', $id)->get();
            
            foreach($child_cats as $cats){
                $cats->parent_id = 0;
                $cats->save();
            }
            return Redirect::back()->with(array('message' => 'Successfully Deleted Category', 'note_type' => 'success') );

    }
    
    
         /*Albums section */
    
    public function CPPalbumIndex(){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $allAlbums = AudioAlbums::where('user_id','=',$user_id)->get();
        $allCategories = AudioCategory::all();
        $data = array(
            'audioCategories' => $allCategories,
            'allAlbums' => $allAlbums,
        );
        return view('moderator.cpp.audios.albums.index',$data);

    }

    public function CPPstoreAlbum(Request $request){
        $user = Session::get('user'); 
        $user_id = $user->id;
        $input = $request->all();
        
        
        $path = public_path().'/uploads/albums/';
            $image_path = public_path().'/uploads/albums/';
            if(empty($input['album'])){
                unset($input['album']);
            } else {
                $image = $input['album'];
                if($image != ''  && $image != null){
                 $file_old = $image_path.$image;
                 if (file_exists($file_old)){
                     unlink($file_old);
                 }
             }
              //upload new file
             $file = $image;
             $input['album']  = $file->getClientOriginalName();
             $file->move($image_path, $input['album']);
         }
        
        
         /*Slug*/
            if ($input['slug'] != '') {
                // $input['slug'] = $this->createAlbumSlug($input['slug']);
                $input['slug'] = $input['slug'];

            }

            if($input['slug'] == ''){
                $input['slug'] = $input['albumname']; 
                // $input['slug'] = $this->createAlbumSlug($input['albumname']);    

            }

            $input['user_id'] = $user_id;

        AudioAlbums::create($input);
        return back()->with('message', 'New Album added successfully.');

    }

    public function CPPupdateAlbum(Request $request){
        $user = Session::get('user'); 
        $user_id = $user->id;
               
        $request = $request->all();
        
         
        
            $id = $request['id'];
            $audio = AudioAlbums::findOrFail($id);
        
           if ($audio->slug != $request['slug']) {
                // $request['slug'] = $this->createAlbumSlug($request['slug'], $id);
                $request['slug'] = $request['slug'];

            }

            if($request['slug'] == '' || $audio->slug == ''){
                $request['slug'] = $request['albumname']; 
                // $request['slug'] = $this->createAlbumSlug($request['albumname']);    
            }

            $path = public_path().'/uploads/albums/';
            $image_path = public_path().'/uploads/albums/';
            if(empty($request['album'])){
                unset($request['album']);
            } else {
                $image = $request['album'];
                if($image != ''  && $image != null){
                 $file_old = $image_path.$image;
                 if (file_exists($file_old)){
                     unlink($file_old);
                 }
             }
              //upload new file
             $file = $image;
             $request['album']  = $file->getClientOriginalName();
             $file->move($image_path, $request['album']);
         }
         $request['user_id'] = $user_id;
        $audio->update($request);
        
        
        if(isset($audio)){
            return Redirect::back()->with(array('message' => 'Successfully Updated Albums', 'note_type' => 'success') );
        }

    }

    public function CPPdestroyAlbum($id){
        $user = Session::get('user'); 
        $user_id = $user->id;

        AudioAlbums::destroy($id);
       
        return Redirect::back()->with(array('message' => 'Successfully Deleted Albums', 'note_type' => 'success') );

}

    public function CPPeditAlbum($id){
        $user = Session::get('user'); 
        $user_id = $user->id;

        $categories = AudioAlbums::where('id', '=', $id)->get();
        $allAlbums = AudioAlbums::all();
        $allCategories = AudioCategory::all();
         $data = array(
                'audioCategories' => $allCategories,
                'allAlbums' => $allAlbums,
                'categories' => $categories
            );
        
        return view('moderator.cpp.audios.albums.edit',$data);

 }

     public function CPPcreateAlbumSlug($title, $id = 0)
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
