<?php

namespace App\Http\Controllers;

use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use App\Artist as Artist;
use DB;
use App\SystemSetting as SystemSetting;
use App\User as User;
use Session;
use App\Setting as Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class CPPAdminArtistsController extends Controller
{
    public function CPPindex(Request $request)
    {

        $data = Session::all();
       
        $user = Session::get('user'); 
        $user_id = $user->id;

        if( empty($user_id) && $user_id == ""){
            return view('blocked');
        }

      $search_value = $request->get('s');
        
        if(!empty($search_value)):
            $artists = Artist::where('uploaded_by','CPP')->where('user_id','=',$user_id)->where('artist_name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $artists = Artist::where('uploaded_by','CPP')->where('user_id','=',$user_id)->orderBy('created_at', 'DESC')->paginate(9);
        endif;
        

        $data = array(
            'artists' => $artists,
            'user' => $user,
            );

        return View::make('moderator.cpp.audios.artist.index', $data);
   
}


    public function CPPcreate()
    {

        $data = Session::all();
       
        $user = Session::get('user'); 
        $user_id = $user->id;

        if( empty($user_id) && $user_id == ""){
            return view('blocked');
        }
   
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Artist',
            'post_route' => URL::to('cpp/artists/store'),
            'button_text' => 'Add New Artist',
            );
        return View::make('moderator.cpp.audios.artist.create_edit', $data);
   
    }

     public function CPPstore(Request $request)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;

        if( empty($user_id) && $user_id == ""){
            return view('blocked');
        }
                    $data = $request->all();
                    $image_path = public_path().'/uploads/artists/';
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

                        if(compress_image_enable() == 1){
    
                            $artist_filename  = time().'.'.compress_image_format();
                            $artist_image     =  'Artist_'.$artist_filename ;
                            Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image,compress_image_resolution() );
                        }else{
        
                            $artist_filename  = time().'.'.$image->getClientOriginalExtension();
                            $artist_image     =  'Artist_'.$artist_filename ;
                            Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image );
                        }  

                        $data['image'] = $artist_image ;

            } else {
                $data['image']  = 'default.jpg';
            } 
        

            if($data['artist_slug'] == null ){

                $artist_slug = preg_replace('/\s+/', '_', $data['artist_name']);
            }else{
                $artist_slug = preg_replace('/\s+/', '_', $data['artist_slug']);
            }

            $artist = Artist::create([
                "artist_name" => $data['artist_name'] ,
                "artist_email" => $data['artist_email'] ,
                "description" => $data['description'] ,
                "image"       => $data['image'] ,
                "artist_type" => $request->artist_type,
                "artist_slug" => $artist_slug ,
                "uploaded_by" => 'CPP' ,
                "user_id" => $user_id ,
            ]);

            $artist_id = $artist->id;

        return Redirect::to('cpp/artists')->with(array('message' => 'New Artist Successfully Added!', 'note_type' => 'success') );
      
       
    }

    public function CPPedit($id)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;

        if( empty($user_id) && $user_id == ""){
            return view('blocked');
        }
        $artist = Artist::where('uploaded_by','CPP')->where('user_id',$user_id)->where('id',$id)->first();

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Artist',
            'artist' => $artist,
            'post_route' => URL::to('cpp/artists/update'),
            'button_text' => 'Update Artist',
            );

        return View::make('moderator.cpp.audios.artist.create_edit', $data);
    }

    public function CPPupdate(Request $request)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;
        
        if( empty($user_id) && $user_id == ""){
            return view('blocked');
        }
                $data = $request->all();
                $id = $request->id;
                $artist = Artist::findOrFail($id);
                $image_path = public_path().'/uploads/artists/';
                $image = (isset($data['image'])) ? $data['image'] : '';

                if(empty($data['image'])){
                    unset($data['image']);
                }
                else {
                    if($image != ''  && $image != null){
                        $file_old = $image_path.$image;
                        if (file_exists($file_old)){
                            unlink($file_old);
                        }
                    }
                    $file = $image;

                    if(compress_image_enable() == 1){
    
                        $artist_filename  = time().'.'.compress_image_format();
                        $artist_image     =  'Artist_'.$artist_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image,compress_image_resolution() );
                    }else{
    
                        $artist_filename  = time().'.'.$file->getClientOriginalExtension();
                        $artist_image     =  'Artist_'.$artist_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/artists/'.$artist_image );
                    }  

                    $data['image'] = $artist_image ;
                }

            if($data['artist_slug'] == null ){

                $artist_slug = preg_replace('/\s+/', '_', $data['artist_name']);
            }else{
                $artist_slug = preg_replace('/\s+/', '_', $data['artist_slug']);
            }
            
            // dd($data['artist_type']);
                $artist->update([
                    "artist_name" => $data['artist_name'] ,
                    "artist_email" => $data['artist_email'] ,
                    "description" => $data['description'] ,
                    "artist_type" => $data['artist_type'] ,
                    "artist_slug" => $artist_slug ,
                    "uploaded_by" => 'CPP' ,
                    "user_id" => $user_id ,
                ]);

                if(!empty($data['image'])){
                    $artist->update([
                        "image"   =>  $data['image']  ,
                    ]);
                }

            return Redirect::to('cpp/artists/edit' . '/' . $id)->with(array('message' => 'Successfully Updated Artist!', 'note_type' => 'success') );
        
    }

    public function CPPdestroy($id)
    {
        $user = Session::get('user'); 
        $user_id = $user->id;

        if( empty($user_id) && $user_id == ""){
            return view('blocked');
        }
        $artist = Artist::find($id);

        $this->deleteArtistImages($artist);

        Artist::destroy($id);

        return Redirect::to('cpp/artists')->with(array('message' => 'Successfully Deleted Artist', 'note_type' => 'success') );

}

    private function deleteArtistImages($artist){
        $ext = pathinfo($artist->image, PATHINFO_EXTENSION);
        if(file_exists(public_path().'/uploads/artists/' . $artist->image) && $artist->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/artists/' . $artist->image);
        }
    }

    public function artist_slug_validation(Request $request)
    {
            $artist_slug = $request->get('artist_slug');

            $button_type = $request->get('button_type');


            if($button_type == "Update Artist"){

                $artist_slug = Artist::where('artist_slug',$artist_slug)->get();

                $message = (count($artist_slug) < 2) ?  "true" : "false";

            }elseif($button_type == "Add New Artist"){

                $artist_slug = Artist::where('artist_slug',$artist_slug)->first();
                $message = ($artist_slug == null) ?  "true" : "false";
            }
            
            return $message;
    }
}
