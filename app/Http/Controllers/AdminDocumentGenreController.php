<?php

namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Setting as Setting;
use App\DocumentGenre as DocumentGenre;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AdminDocumentGenreController extends Controller
{
    public function index()
    {

        $genre = DocumentGenre::orderBy('order')->get()->map( function($item){
            $item['image_url'] = !is_null($item->image )? URL::to('public/uploads/videocategory/'.$item->image) : default_vertical_image_url() ;
            return $item;
        });
          
        $data = array (
          'allCategories'=>$genre
        );
        

        return view('admin.document.genre.index',$data);

    }

    public function Document_Store(Request $request)
    {
        $inputs = array(
            'parent_id' => $request->parent_id,
            'name'      => $request->name, 
            'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
            'active'   => $request->active ,
            'order'     => DocumentGenre::max('order') + 1 ,
        );

        if($request->hasFile('image')){
    
            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'Document-Genre-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'Document-Genre-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        $DocumentGenre = DocumentGenre::create($inputs);

        return back()->with('message', 'New Genre added successfully.');
    }

    public function Document_Edit($id)
    {
         
        $categories = DocumentGenre::where('id', '=', $id)->get();

        $allCategories = DocumentGenre::all();

        return view('admin.document.genre.create_edit',compact('categories','allCategories'));
    }

    public function Document_Update(Request $request)
    {

        $id = $request['id'];

        $inputs = array(
            'parent_id' => $request->parent_id,
            'name'      => $request->name, 
            'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
            'active'   => $request->active ,
        );

        if($request->hasFile('image')){
    
            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'Document-Genre-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'Document-Genre-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/videocategory/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        DocumentGenre::find($id)->update($inputs);
          
        return Redirect::to('admin/document/genre')->with(array('message' => 'Successfully Updated Genre', 'note_type' => 'success') );
    }

    public function Document_Delete(Request $request,$id)
    {
        DocumentGenre::destroy($id);
        
        return Redirect::to('admin/document/genre')->with(array('message' => 'Successfully Deleted Genre', 'note_type' => 'success') );
    }

    public function Document_Order(Request $request){

        $input = $request->all();
        $position = $_POST['position'];

        $i=1;
        foreach($position as $k=>$v){
          $videocategory = DocumentGenre::find($v);
          $videocategory->order = $i;
          $videocategory->save();
          $i++;
        }
        return 1;
    }

    public function Document_Active(Request $request)
    {
        try {
            $category = DocumentGenre::where('id',$request->category_id)->update([
                'active' => $request->active,
            ]);

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    }

}
