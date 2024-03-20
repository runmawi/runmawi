<?php

namespace App\Http\Controllers;

use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Setting as Setting;
use App\Document as Document;
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


class AdminDocumentController extends Controller
{
    public function index()
    {

        $Document = Document::get()->map( function($item){
            $item['image_url'] = !is_null($item->image )? URL::to('public/uploads/Document/'.$item->image) : default_vertical_image_url() ;
            $item['document_url'] = !is_null($item->document )? URL::to('public/uploads/Document/'.$item->document) : default_vertical_image_url() ;
            return $item;
        });
          
        $data = array (
          'Document'        => $Document,
          'DocumentGenre'   => DocumentGenre::get(),
        );
        
        return view('admin.document.index',$data);

    }

    public function List()
    {

        $Document = Document::get()->map( function($item){
            $item['image_url'] = !is_null($item->image )? URL::to('public/uploads/Document/'.$item->image) : default_vertical_image_url() ;
            $item['document_url'] = !is_null($item->document )? URL::to('public/uploads/Document/'.$item->document) : default_vertical_image_url() ;
            return $item;
        });
          
        $data = array (
          'Documents'        => $Document,
          'DocumentGenre'   => DocumentGenre::get(),
        );
        
        return view('admin.document.List',$data);

    }

    public function store(Request $request)
    {

        $inputs = array(
            'name'      => $request->name, 
            'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
            'category'      => (!empty($request->document_category) ) ? json_encode($request->document_category) : null,
        );

        $directory = public_path('uploads/Document');

        // Check if the directory doesn't exist
        if (!file_exists($directory)) {
            // Attempt to create the directory
            if (!mkdir($directory, 0777, true)) { // 0777 is the permission mode
                // If unable to create directory, display an error message
                die('Failed to create directory.');
            }
        }
        
        if($request->hasFile('image')){
    
            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'Document-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/Document/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'Document-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/Document/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        if($request->hasFile('document')){

            $file = $request->document;
            // Generate a unique filename
            $filename = 'Document-' . time() . '.' . $file->getClientOriginalExtension();

            // Move the uploaded file to the desired directory
            $file->move(public_path('uploads/Document'), $filename);

            // Add the filename to your inputs array or perform any other operations you need
            $inputs += ['document' => $filename];
        }
        $Document = Document::create($inputs);
        // dd($inputs);

        return Redirect::to('admin/document/list')->with(array('message' => 'Successfully Added Document', 'note_type' => 'success') );
    }

    public function Edit($id)
    {
         
        $Document = Document::where('id', '=', $id)->first();

        $category_Document = Document::where('id', $id)->pluck('category')->first();


        $allCategories = DocumentGenre::all();
        $data = array (
            'Document'        => $Document,
            'DocumentGenre'   => DocumentGenre::get(),
            'category_Document' => ($category_Document != null) ?  DocumentGenre::whereIn('id', json_decode($category_Document))->pluck('id')->toArray() : [],
            );
          
          return view('admin.document.create_edit',$data);
          
    }

    public function Update(Request $request)
    {

        $id = $request['id'];

        $inputs = array(
            'name'      => $request->name, 
            'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->name) ,
            'category'      => (!empty($request->document_category) ) ? json_encode($request->document_category) : null,
        );

        if($request->hasFile('image')){
    
            $file = $request->image;

            if(compress_image_enable() == 1){

                $filename   = 'Document-'.time().'.'.compress_image_format();
                Image::make($file)->save(base_path().'/public/uploads/Document/'.$filename ,compress_image_resolution() );

            }else{

                $filename   = 'Document-'.time().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(base_path().'/public/uploads/Document/'.$filename );
            }

            $inputs +=  ['image' => $filename ];
        }

        if($request->hasFile('document')){

            $file = $request->document;
            
            $filename = 'Document-' . time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/Document'), $filename);

            $inputs += ['document' => $filename];
        }

        Document::find($id)->update($inputs);
          
        return Redirect::to('admin/document/list')->with(array('message' => 'Successfully Updated Document', 'note_type' => 'success') );
    }

    public function Delete(Request $request,$id)
    {
        Document::destroy($id);
        
        return Redirect::to('admin/document/list')->with(array('message' => 'Successfully Deleted Genre', 'note_type' => 'success') );
    }


}
