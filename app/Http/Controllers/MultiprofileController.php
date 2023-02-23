<?php

namespace App\Http\Controllers;

use App\Multiprofile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\HomeSetting;
use App\Setting;
use App\User;
use Session;
use Theme;
use Auth;
use DB;

class MultiprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private $construct_name;
    
    public function __construct()
    {
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function index() 
    {
        $user_id=Auth::User()->id;
        $user=User::where('id',$user_id)->first();
        $multiprofile=Multiprofile::where('parent_id',$user_id)->get();

        return Theme::view ('multiprofile.index',compact('multiprofile',$multiprofile ,'user',$user));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Theme::view ('multiprofile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->user_type != ''){
            $user_type = 'Kids';
        }
        else{
            $user_type = 'Normal';
        }
        $parent_id = Auth::User()->id;
        if($request->image != null){
            $files = $request->image;
            $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
        }
        else{
            $filename='chooseimage.jpg';
        }
       
        $Multiprofile = Multiprofile::create([
            'parent_id'       => $parent_id,
            'user_name'       => $request->input('name'),
            'user_type'       => $user_type,
            'Profile_Image'   => $filename,
         ]);
    
         return redirect('choose-profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Multiprofile  $multiprofile
     * @return \Illuminate\Http\Response
     */
    public function show(Multiprofile $multiprofile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Multiprofile  $multiprofile
     * @return \Illuminate\Http\Response
     */
    public function edit(Multiprofile $multiprofile,$id)
    {
        $multiprofile = Multiprofile::where('id', '=', $id)->firstOrFail();
        return Theme::view ('multiprofile.edit',compact('multiprofile',$multiprofile ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Multiprofile  $multiprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Multiprofile $multiprofile,$id)
    {
        $Multiprofile = Multiprofile::find($id);  
        if($request->user_type != ''){
            $user_type = 'Kids';
        }
        else{
            $user_type = 'Normal';
        }

        if($request->image != ''){  
            $files = $request->image;
            $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
            $Multiprofile->Profile_Image = $filename;
        }
        $Multiprofile->user_name =  $request->get('name');  
        $Multiprofile->user_type = $user_type;  
        $Multiprofile->save();  

        return redirect('choose-profile');
    }

    /**
     * 
     * Remove the specified resource from storage.
     *
     * @param  \App\Multiprofile  $multiprofile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Multiprofile $multiprofile)
    {
        //
    }

    public function profileDetails_edit(Request $request,$id)
    {
        $multiprofile = Multiprofile::where('id', '=', $id)->firstOrFail();
        return Theme::view ('multiprofile.profileEdit',compact('multiprofile',$multiprofile ));

    }

    public function profile_details(Request $request,$id){

        $Multiprofile = Multiprofile::find($id);  
        if($request->user_type != ''){
            $user_type = 'Kids';
        }
        else{
            $user_type = 'Normal';
        }

        if($request->image != ''){  
            $files = $request->image;
            $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
            $Multiprofile->Profile_Image = $filename;
        }
        $Multiprofile->user_name =  $request->get('name');  
        $Multiprofile->user_type = $user_type;  
        $Multiprofile->save();  

        return redirect('myprofile');
    }

    public function profile_delete($id){

        $profile_delete=Multiprofile::find($id)->delete();

        return redirect('myprofile');
    }

    public function Multi_Profile_Create( Request $request )
    {
        return Theme::view ('multiprofile.profile_create');

    }

    public function Multi_Profile_Store(Request $request)
    {
        if($request->user_type != ''){
            $user_type = 'Kids';
        }
        else{
            $user_type = 'Normal';
        }

        $parent_id = Auth::User()->id;

        if($request->image != null){
            $files = $request->image;
            $filename =uniqid(). time(). '.' . $files->getClientOriginalExtension();
            Image::make($files)->resize(300, 300)->save(base_path().'/public/multiprofile/'.$filename );
        }
        else{
            $filename='chooseimage.jpg';
        }
       
        $Multiprofile = Multiprofile::create([
            'parent_id'       => $parent_id,
            'user_name'       => $request->input('name'),
            'user_type'       => $user_type,
            'Profile_Image'   => $filename,
         ]);
    
         return redirect( route('myprofile') );
    }
}
