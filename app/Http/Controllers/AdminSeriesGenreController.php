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
use Illuminate\Support\Str;


class AdminSeriesGenreController extends Controller
{
    public function index()
    {

        $genre = SeriesGenre::orderBy('order')->get()->map( function($item){
            $item['image_url'] = !is_null($item->image )? URL::to('public/uploads/videocategory/'.$item->image) : default_vertical_image_url() ;
            return $item;
        });
          
        $data = array (
          'allCategories'=>$genre
        );
        

        return view('admin.genre.index',$data);

    }

    public function Series_genre_store(Request $request)
    {
        $inputs = array(
            'parent_id' => $request->parent_id,
            'name'      => $request->name, 
            'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
            'in_home'   => $request->in_home ,
            'footer'    => $request->footer,
            'banner'    => $request->banner,
            'in_menu'   => $request->in_menu ,
            'order'     => SeriesGenre::max('order') + 1 ,
            'category_list_active' => $request->category_list_active ,
        );

        if($request->hasFile('image')){
    
            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'series-Genre-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'series-Genre-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        if($request->hasFile('banner_image')){

            $file = $request->banner_image;

            if(compress_image_enable() == 1){

                $filename   = 'series-Genre-banner-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'series-Genre-banner-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename );
            }

            $inputs +=  ['banner_image' => $filename ];
        }

        $SeriesGenre = SeriesGenre::create($inputs);

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

        // $input = $request->all();
        // $path = public_path().'/uploads/videocategory/';

        $id = $request['id'];
        // $category = SeriesGenre::find($id);

        // if (isset($request['image']) && !empty($request['image'])){
        //        $image = $request['image']; 
        //     } else {
        //         $request['image'] = $category->image;
        //  }

        //  if( isset($image) && $image!= '') {   
        //     if ($image != ''  && $image != null) {
        //         $file_old = $path.$image;
        //         if (file_exists($file_old)){
        //                unlink($file_old);
        //         }
        //     }
        //         $file = $image;
        //         $category->image = str_replace(' ', '_', $file->getClientOriginalName());
        //         $file->move($path,$category->image);
        //     } 

        //  $category->name = $request['name'];
        //  $category->slug = $request['slug'];
        //  $category->parent_id = $request['parent_id'];
        //  $category->in_menu = $request['in_menu']; 
        //  $category->category_list_active = $request['category_list_active']; 

        //  if ( $category->slug != '') {
        //     $category->slug  =str_replace(' ', '_',  $request['slug']);
        //   } else {
        //      $category->slug  = str_replace(' ', '_', $request['name']);
        //   }

        //   $category->save();
          
        //   return Redirect::to('admin/Series/Genre')->with(array('message' => 'Successfully Updated Genre', 'note_type' => 'success') );


        $inputs = array(
            'parent_id' => $request->parent_id,
            'name'      => $request->name, 
            'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
            'in_home'   => $request->in_home ,
            'footer'    => $request->footer,
            'banner'    => $request->banner,
            'in_menu'   => $request->in_menu ,
            'category_list_active' => $request->category_list_active ,
        );

        if($request->hasFile('image')){
    
            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'series-Genre-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'series-Genre-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        if($request->hasFile('banner_image')){

            $file = $request->banner_image;

            if(compress_image_enable() == 1){

                $filename   = 'series-Genre-banner-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'series-Genre-banner-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename );
            }

            $inputs +=  ['banner_image' => $filename ];
        }

        SeriesGenre::find($id)->update($inputs);
          
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

    public function series_category_active(Request $request)
    {
        try {
            $category = SeriesGenre::where('id',$request->category_id)->update([
                'in_menu' => $request->status,
            ]);

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    }

}
