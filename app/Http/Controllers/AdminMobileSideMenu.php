<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\Script as Script;
use App\Playerui as Playerui;
use App\AppSetting as AppSetting;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use App\ThumbnailSetting;
use App\RTMP;
use Illuminate\Support\Facades\Storage;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\FooterLink;
use App\LinkingSetting;
use App\CompressImage;
use App\MobileSideMenu;


class AdminMobileSideMenu extends Controller
{

public function Side_link(Request $request)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }

      else
      {

            $MobileSideMenu = MobileSideMenu::orderBy('order')->get();
            return view('admin.mobilemenu.index',compact('MobileSideMenu',$MobileSideMenu));
      }     
    }

    public function Side_link_store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $image  =  (isset($data['image'])) ? $data['image'] : '';

        $MobileSideMenu  = MobileSideMenu::create([
          'name'   => $request->name ,
          'short_note'   => $request->short_note ,
        ]);
        $MobileSideMenu->order = $MobileSideMenu->id;
        $image_path    =   public_path().'/uploads/images/';
          
        if($image != '') {     
            if($image != ''  && $image != null){   
                //code for remove old file
                    $file_old = $image_path.$image;
                if (file_exists($file_old)){
                    unlink($file_old);
                }
            }
            
        //upload new file

            $image = $image;   
            // $data['image']  = $image->getClientOriginalName();
            $data['image'] = str_replace(' ', '_', $image->getClientOriginalName());
            $image->move($image_path, $data['image']);
            // $image = $file->getClientOriginalName();
            $MobileSideMenu->image = URL::to('/public/uploads/images/').'/'.str_replace(' ', '_', $image->getClientOriginalName());
        } 
        else {
            $MobileSideMenu->image = "";
        }

        $MobileSideMenu->save();

        return redirect()->route('Side_link');
    }

    public function Side_order_update(Request $request){

        $Side_order = MobileSideMenu::all();

        foreach ($Side_order as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order' => $order['position']]);
                }
            }
        }
        return response('Update Successfully.', 200);
    }

    public function Side_edit($id)
    {

      $MobileSideMenu = MobileSideMenu::where('id',$id)->first();
      return view('admin.mobilemenu.edit',compact('MobileSideMenu',$MobileSideMenu));
    }

    public function Side_update(Request $request)
    {

    $data = $request->all();
    $image  =  (isset($data['image'])) ? $data['image'] : '';
    $image_path    =   public_path().'/uploads/images/';

        // dd($data);
    $Side_menu = MobileSideMenu::find($request->id);

    if($image != '') {     
        if($image != ''  && $image != null){   
            //code for remove old file
                $file_old = $image_path.$image;
            if (file_exists($file_old)){
                unlink($file_old);
            }
        }
        
    //upload new file

        $image = $image;   
        // $data['image']  = $image->getClientOriginalName();
        $data['image'] = str_replace(' ', '_', $image->getClientOriginalName());
        $image->move($image_path, $data['image']);
        // $image = $file->getClientOriginalName();
        $icon = URL::to('/public/uploads/images/').'/'.str_replace(' ', '_', $image->getClientOriginalName());
    } 
    else {
        $icon = $Side_menu->image;
    }

    $Side_menu->name = $request->get('name');
    $Side_menu->short_note = $request->get('short_note');
    $Side_menu->image = $icon;
    $Side_menu->update();

     return redirect()->route('Side_link');

    }

    public function Side_delete($id)
    {
        MobileSideMenu::destroy($id);
        return redirect()->route('Side_link');
    }
}