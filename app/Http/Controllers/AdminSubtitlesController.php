<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use View;
use Validator;
use File;
use getID3;
use URL;
use Auth;
use Hash;
use App\Subtitle as Subtitle;
use App\User as User;
use \Redirect as Redirect;

class AdminSubtitlesController extends Controller
{
    public function index(){
            
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
        );
            return View::make('admin.expired_dashboard', $data);
        }else{
    
            $user = Auth::user();

            $data = array(
                'user' => $user,
                "subtitles" => Subtitle::all(),
            );

            return View::make('admin.subtitle.index', $data);
        }
    }

    
    public function store(Request $request)
    {
      $input = $request->all();

      $Subtitles = new Subtitle;
      $Subtitles->language = $input['language'];
      $Subtitles->short_code = $input['shortcode'];
      $Subtitles->save();
      return Redirect::back();
 
    }

    public function update(Request $request)
    {
      $input = $request->all();
      $id = $input['id'];

      $Subtitles = Subtitle::find($id);     

      $Subtitles->language = $input['language'];
      $Subtitles->short_code = $input['short_code'];
      $Subtitles->save();
    
      return Redirect::back()->with(array('message' => 'Successfully Updated Site Settings!', 'note_type' => 'success') );
    }


    public function edit($id)
    {
        
        $Subtitles = Subtitle::where('id','=',$id)->first();          
         $data = array(
                   'Subtitles' => $Subtitles ,   
         );
        return view('admin.subtitle.edit',$data);
    }


    public function destroy($id)
    {
        
        Subtitle::destroy($id);
        
         return Redirect::back();
    }

}