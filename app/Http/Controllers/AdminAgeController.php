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
use App\AgeCategory as AgeCategory;
use DB;
use App\Video as Video;



class AdminAgeController extends Controller
{
    public function index(Request $request)
    {
        $allCategories = AgeCategory::all();
        return view('admin.videos.categories.age_index',compact('allCategories'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $age = new AgeCategory();
        $age->age = $request['age']; 
        $age->slug =$request['age'].' '.'Plus'; 
        $age->active =$request['active']; 
        $age->save();

        return Redirect::back();

    }
    public function edit($id){
         
        $categories = AgeCategory::where('id', '=', $id)->get();

        $allCategories = AgeCategory::all();
        return view('admin.videos.categories.age_edit',compact('categories','allCategories'));
    }


 public function update(Request $request){
       
    $input = $request->all();
       
    $id = $request['id'];
    // dd($input);
    $category = AgeCategory::find($id);
     
        $category->age = $input['age'];
        $category->slug =$input['slug']; 
        $category->active =$input['active']; 
        $category->save();
        return Redirect::back();
        
        
}


public function destroy($id){
    
    // $video = DB::table('videos')
    // ->join('age_categories', 'videos.age_restrict', '=', 'age_categories.age')
    // ->where('age_categories.id', '=', $id)
    // ->select('videos.*')
    // ->get();
    $video = Video::join('age_categories', 'videos.age_restrict', '=', 'age_categories.age')
    ->where('age_categories.id', '=', $id)
    ->select('videos.*')
    ->get();
    $message = "This Age are added With videos";
    $delete = "Are You Sure to delete";
    if(!$video->isEmpty()){
        foreach($video as $videos){
            echo "<script>alert('$message')</script>";   
    
                if(!empty($search_value)):
                    $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
                else:
                    $videos = Video::where('age_restrict','=',$id)->orderBy('created_at', 'DESC')->paginate(9);
                endif;
                $user = Auth::user();
                $data = array(
                    'videos' => $videos,
                    'user' => $user,
                    'admin_user' => Auth::user()
                    );
    
                return View('admin.videos.index', $data);
                }
            
    }else{
        echo "<script>alert('$delete')</script>";   

        AgeCategory::destroy($id);
        
        return Redirect::back();
    }

}

} 