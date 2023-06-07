<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreVideoRequest;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use URL;
use Hash;
use Image;
use Auth;
use File;
use Mail;
use Session;
use Redirect;
use App\SiteMeta;
use \App\User as User;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminSiteMetaController extends Controller
{   

    public function meta_setting()
    {
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $SiteMeta_settings = SiteMeta::get();          
            $data = array(
                        'SiteMeta_settings' => $SiteMeta_settings ,   
            );
            return view('admin.site_meta.index',$data);
        }
    }
  
      public function meta_setting_update(Request $request)
      {
        $input = $request->all();
        // dd($input['meta_image']);
        $meta_image = isset($input["meta_image"]) ? $input["meta_image"]: "";
        $image_path = public_path() . "/uploads/images/";

        if (!empty($meta_image))
        {
            if ($meta_image != '' && $meta_image != null)
            {
                $file_old = $image_path . $meta_image;
                if (file_exists($file_old))
                {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $meta_image;
            $data['meta_image'] = str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($image_path, $data['meta_image']);
            $image = URL::to('/public/uploads/images').'/'.$data['meta_image'];
        }
        else
        {
            $image = null;
        }


        $SiteMeta = SiteMeta::find($request->id);     

        $SiteMeta->page_name = $input['page_name'];
        $SiteMeta->page_title = $input['page_title'];
        $SiteMeta->meta_description = $input['meta_description'];      
        $SiteMeta->meta_keyword = $input['meta_keyword'];
        $SiteMeta->meta_image = $image; 
        $SiteMeta->user_id = Auth::User()->id;
        $SiteMeta->save();
 
        return Redirect::back()->with(array('message' => 'Successfully Updated Site Meta Settings!', 'note_type' => 'success') );
      }
  
  
      public function meta_setting_edit($id)
      {
        $page_name = [
            'home' => 'Home',
            'categoryList' => 'Category List',
            'AudiocategoryList' => 'Audio category List',
            'SeriescategoryList' => 'Series Category List',
            'CategoryLive' => 'Category Live',
            'artist-list' => 'Artist List',
            'Channel-list' => 'Channel List',
            'content-partners' => 'Content Partners',
            'Reset-Password' => 'Reset Password',
            'login' => 'Login',
            'signup' => 'Signup',
            'upgrade-subscription_plan' => 'Upgrade Subscription Plan',
            'myprofile' => 'My Profile',
            'transactiondetails' => 'Transactiondetails',
            'language-list' => 'Language List',
            'Most-watched-videos' => 'Most Watched Videos',
            'Most-watched-videos-country' => 'Most Watched Videos Country',
            'Most-watched-videos-site' => 'Most Watched Videos Site',
            'continue-watching-list' => 'Continue Watching List',
            'latest-videos' => 'Home',
            'mywishlists' => 'My Wishlists',
            'watchlater' => 'Watchlater',
          ];
        // dd($page_name);
          $SiteMeta = SiteMeta::where('id','=',$id)->first();          
           $data = array(
                     'SiteMeta' => $SiteMeta ,   
                     'page_name' => $page_name ,   
           );
          return view('admin.site_meta.edit',$data);
      }
  
  
      public function Delete($id)
      {
          
        SiteMeta::destroy($id);
          
           return Redirect::back();
      }

}