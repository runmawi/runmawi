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

class AdminAudioCategoriesController extends Controller
{
      public function index(){
          
        $categories = AudioCategory::where('parent_id', '=', 0)->get();

        $allCategories = AudioCategory::all();
          
          
          
        $data = array (
            'allCategories'=>$allCategories,
            'categories'=>$categories,
          );
         
        return view('admin.audios.categories.index',$data);
         
      }
    
    
     public function store(Request $request){
          
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
          
            AudioCategory::create($input);
            return back()->with('success', 'New Category added successfully.');
       }
    
    public function edit($id){
         
            $categories = AudioCategory::where('id', '=', $id)->get();

            $allCategories = AudioCategory::all();
            return view('admin.audios.categories.edit',compact('categories','allCategories'));
        }
    
    
        public function update(Request $request){
           
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
            
            
            $category->save();

            return Redirect::to('admin/audios/categories')->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
            
            }
    
        
    
        public function destroy($id){
            
            AudioCategory::destroy($id);
            
            $child_cats = AudioCategory::where('parent_id', '=', $id)->get();
            
            foreach($child_cats as $cats){
                $cats->parent_id = 0;
                $cats->save();
            }
            return Redirect::to('admin/audios/categories')->with(array('note' => 'Successfully Deleted Category', 'note_type' => 'success') );
        }
    
    
         /*Albums section */
    
    public function albumIndex(){
        $allAlbums = AudioAlbums::all();
        $allCategories = AudioCategory::all();
        $data = array(
            'audioCategories' => $allCategories,
            'allAlbums' => $allAlbums,
        );
        return view('admin.audios.albums.index',$data);
   
    }

    public function storeAlbum(Request $request){
        
        $input = $request->all();
        
        $path = public_path().'/uploads/audios/';
        
        $image = $request['image'];
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
        
        
         /*Slug*/
            if ($input['slug'] != '') {
                $input['slug'] = $this->createAlbumSlug($input['slug']);
            }

            if($input['slug'] == ''){
                $input['slug'] = $this->createAlbumSlug($input['albumname']);    
            }


        AudioAlbums::create($input);
        return back()->with('success', 'New Album added successfully.');

    }

    public function updateAlbum(Request $request){

        
        
               
        $request = $request->all();
        
         
        
            $id = $request['id'];
            $audio = AudioAlbums::findOrFail($id);
        
           if ($audio->slug != $request['slug']) {
                $request['slug'] = $this->createAlbumSlug($request['slug'], $id);
            }

            if($request['slug'] == '' || $audio->slug == ''){
                $request['slug'] = $this->createAlbumSlug($request['albumname']);    
            }

            $path = public_path().'/uploads/audios/';
            if (isset($request['image']) && !empty($request['image'])){
                $image = $request['image']; 
            } else {
               $request['image'] = '';
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
             $request['image']  = $file->getClientOriginalName();
             $file->move($path,$request['image']);

         } 
        
        $audio->update($request);
        
        
        if(isset($audio)){
            return Redirect::to('admin/audios/albums')->with(array('note' => 'Successfully Updated Albums', 'note_type' => 'success') );
        }
    }

    public function destroyAlbum($id){
        AudioAlbums::destroy($id);
       
        return Redirect::to('admin/audios/albums')->with(array('note' => 'Successfully Deleted Albums', 'note_type' => 'success') );
    }

    public function editAlbum($id){
        $categories = AudioAlbums::where('id', '=', $id)->get();
        $allAlbums = AudioAlbums::all();
        $allCategories = AudioCategory::all();
         $data = array(
                'audioCategories' => $allCategories,
                'allAlbums' => $allAlbums,
                'categories' => $categories
            );
        
        return view('admin.audios.albums.edit',$data);
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
