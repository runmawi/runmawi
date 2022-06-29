<?php

namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Setting as Setting;
use App\SeriesGenre as SeriesGenre;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class AdminSeriesGenreController extends Controller
{
    public function index()
    {

        $genre = SeriesGenre::orderBy('order')->get();
          
        $data = array (
          'allCategories'=>$genre
        );

        return view('admin.genre.index',$data);

    }

    public function Series_genre_store(Request $request)
    {
        $input = $request->all();

        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

        $slug = $request['slug']; 

        $in_menu = $request['in_menu']; 

        $in_home = $request['in_home']; 

        if ( $slug != '') {
            $input['slug']  =  str_replace(' ', '_',  $request['slug']);
        } else {
             $input['slug']  = str_replace(' ', '_', $request['name']);
        } 

        if ( $in_home != '') {
            $input['in_home']  = $request['in_home'];
        } else {
             $input['in_home']  = $request['in_home'];
        }


        $path = public_path().'/uploads/videocategory/';

        $image = $request['image']; 
        if($image != '') {   
            if($image != ''  && $image != null){
                     $file_old = $path.$image;
                if (file_exists($file_old)){
                     unlink($file_old);
                }
            }
            $file = $image;
            $input['image'] = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $input['image']);
        } 
        else {
                 $input['image']  = 'default.jpg';
        }

        $SeriesGenre = SeriesGenre::create($input);
        $SeriesGenre->order = $SeriesGenre->id;
        $SeriesGenre->save();

        return back()->with('message', 'New Genre added successfully.');

    }

    public function Series_genre_edit($id)
    {
         
        $categories = SeriesGenre::where('id', '=', $id)->get();

        $allCategories = SeriesGenre::all();

        return view('admin.genre.create_edit',compact('categories','allCategories'));
    }

    public function Series_genre_update(Request $request)
    {
        $input = $request->all();
        $path = public_path().'/uploads/videocategory/';

        $id = $request['id'];
        $category = SeriesGenre::find($id);

        if (isset($request['image']) && !empty($request['image'])){
               $image = $request['image']; 
            } else {
                $request['image'] = $category->image;
         }

         if( isset($image) && $image!= '') {   
            if ($image != ''  && $image != null) {
                $file_old = $path.$image;
                if (file_exists($file_old)){
                       unlink($file_old);
                }
            }
                $file = $image;
                $category->image = str_replace(' ', '_', $file->getClientOriginalName());
                $file->move($path,$category->image);
            } 

         $category->name = $request['name'];
         $category->slug = $request['slug'];
         $category->parent_id = $request['parent_id'];
         $category->in_menu = $request['in_menu']; 
         
         if ( $category->slug != '') {
            $category->slug  =str_replace(' ', '_',  $request['slug']);
          } else {
             $category->slug  = str_replace(' ', '_', $request['name']);
          }

          $category->save();
          
          return Redirect::to('admin/Series/Genre')->with(array('message' => 'Successfully Updated Genre', 'note_type' => 'success') );

    }

    public function Series_genre_delete(Request $request,$id)
    {
        SeriesGenre::destroy($id);
        
        return Redirect::to('admin/Series/Genre')->with(array('message' => 'Successfully Deleted Genre', 'note_type' => 'success') );
    }

    public function Series_genre_order(Request $request){

        $input = $request->all();
        $position = $_POST['position'];

        $i=1;
        foreach($position as $k=>$v){
          $videocategory = SeriesGenre::find($v);
          $videocategory->order = $i;
          $videocategory->save();
          $i++;
        }
        return 1;
    }
}
