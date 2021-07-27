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


class AdminArtistsController extends Controller
{
    public function index(Request $request)
    {

      $search_value = $request->get('s');
        
        if(!empty($search_value)):
            $artists = Artist::where('artist_name', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $artists = Artist::orderBy('created_at', 'DESC')->paginate(9);
        endif;
        
        $user = Auth::user();

        $data = array(
            'artists' => $artists,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.artist.index', $data);
    }

    public function create()
    {
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Artist',
            'post_route' => URL::to('admin/artists/store'),
            'button_text' => 'Add New Artist',
            'admin_user' => Auth::user(),
            );
        return View::make('admin.artist.create_edit', $data);
    }

     public function store(Request $request)
    {
    	$data = $request->all();

        $image_path = public_path().'/uploads/artists/';
        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){  
              //code for remove old file
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
             $data['image']  = 'default.jpg';
         } 
       
        $artist = Artist::create($data);
        $artist_id = $artist->id;

        return Redirect::to('admin/artists')->with(array('note' => 'New Artist Successfully Added!', 'note_type' => 'success') );
    
    }

    public function edit($id)
    {
        $artist = Artist::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Artist',
            'artist' => $artist,
            'post_route' => URL::to('admin/artists/update'),
            'button_text' => 'Update Artist',
            'admin_user' => Auth::user(),
            );

        return View::make('admin.artist.create_edit', $data);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $request->id;
        $artist = Artist::findOrFail($id);
        $image_path = public_path().'/uploads/artists/';
        $image = (isset($data['image'])) ? $data['image'] : '';
        if(empty($data['image'])){
            unset($data['image']);
        } else {
            //code for remove old file
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


        $artist->update($data);

        return Redirect::to('admin/artists/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Artist!', 'note_type' => 'success') );
    }

    public function destroy($id)
    {
        $artist = Artist::find($id);

        $this->deleteArtistImages($artist);

        Artist::destroy($id);

        return Redirect::to('admin/artists')->with(array('note' => 'Successfully Deleted Artist', 'note_type' => 'success') );
    }

    private function deleteArtistImages($artist){
        $ext = pathinfo($artist->image, PATHINFO_EXTENSION);
        if(file_exists(public_path().'/uploads/artists/' . $artist->image) && $artist->image != 'placeholder.jpg'){
            @unlink(public_path().'/uploads/artists/' . $artist->image);
        }
    }
}
