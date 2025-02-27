<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeSetting as HomeSetting;
use \Redirect as Redirect;
use URL;
use Auth;
use App\Setting as Setting;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use App\User as User;
use App\OrderHomeSetting as OrderHomeSetting;
use App\MobileHomeSetting as MobileHomeSetting;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\RokuHomeSetting;

class HomeSettingsController extends Controller
{
    public function index(){
        
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
        }else{

        $settings = HomeSetting::first();   
        $order_settings = OrderHomeSetting::orderBy('order_id', 'asc')->get();  
        $order_settings_list = OrderHomeSetting::get();  
        $mobilesettings = MobileHomeSetting::first();   
        $rokusettings = RokuHomeSetting::first();  
        
        // dd($rokusettings);


        $data = array(
            "settings" =>$settings ,
            "order_settings" =>$order_settings ,
            "order_settings_list" =>$order_settings_list ,
            "mobilesettings" =>$mobilesettings ,
            "rokusettings" =>$rokusettings ,

        );
        return view('admin.settings.homepage',$data);
    }
    }
    public function save_settings(Request $request){
       
        $settings = HomeSetting::first();
        if(!empty($request['featured_videos'])){
            $settings->featured_videos = 1;
        } 
        if(empty($request['featured_videos'])){
            $settings->featured_videos = 0;
        } 

        if(!empty($request['latest_videos'])){
            $settings->latest_videos = 1;
        } 
        if(empty($request['latest_videos'])){
            $settings->latest_videos = 0;
        } 

        if(!empty($request['category_videos'])){
            $settings->category_videos = 1;
        } 
        if(empty($request['category_videos'])){
            $settings->category_videos = 0;
        } 
        if(!empty($request['live_videos'])){
            $settings->live_videos = 1;
        } 
        if(empty($request['live_videos'])){
            $settings->live_videos = 0;
        } 
        if(!empty($request['audios'])){
            $settings->audios = 1;
        } 
        if(empty($request['audios'])){
            $settings->audios = 0;
        } 
        if(!empty($request['albums'])){
            $settings->albums = 1;
        } 
        if(empty($request['albums'])){
            $settings->albums = 0;
        } 
        if($request['series'] == null){
            $settings->series = 0;
        }else{
            $settings->series = 1;

        } 
        if($request->Recommendation !=null){
            $settings->Recommendation = 1;
        }else{
            $settings->Recommendation = 0;
        }

        if($request->live_category !=null){
            $settings->live_category = 1;
        }else{
            $settings->live_category = 0;
        }

        if($request->artist !=null){
            $settings->artist = 1;
        }else{
            $settings->artist = 0;
        }

        if($request->AutoIntro_skip !=null){
            $settings->AutoIntro_skip = 1;
        }else{
            $settings->AutoIntro_skip = 0;
        }

        if($request->prevent_inspect !=null){
            $settings->prevent_inspect = 1;
        }else{
            $settings->prevent_inspect = 0;
        }

        if( $request->pop_up !=null ){
            $settings->pop_up = 1;
        }else{
            $settings->pop_up = 0;
        }

        $settings->continue_watching =  $request->continue_watching !=null ? 1 : 0 ;
        $settings->video_schedule = !empty($request->video_schedule) ?  "1" : "0" ;
        $settings->videoCategories = !empty($request->videoCategories) ?  "1" : "0" ;
        $settings->liveCategories = !empty($request->liveCategories) ?  "1" : "0" ;
        $settings->channel_partner = !empty($request->channel_partner) ?  "1" : "0" ;
        $settings->content_partner = !empty($request->content_partner) ?  "1" : "0" ;
        $settings->latest_viewed_Videos = !empty($request->latest_viewed_Videos) ?  "1" : "0" ;
        $settings->latest_viewed_Livestream = !empty($request->latest_viewed_Livestream) ?  "1" : "0" ;
        $settings->latest_viewed_Audios = !empty($request->latest_viewed_Audios) ?  "1" : "0" ;
        $settings->latest_viewed_Episode = !empty($request->latest_viewed_Episode) ?  "1" : "0" ;

        $settings->SeriesGenre = !empty($request->SeriesGenre) ?  "1" : "0" ;
        $settings->SeriesGenre_videos = !empty($request->SeriesGenre_videos) ?  "1" : "0" ;
        $settings->AudioGenre = !empty($request->AudioGenre) ?  "1" : "0" ;
        $settings->AudioGenre_audios = !empty($request->AudioGenre_audios) ?  "1" : "0" ;
        $settings->AudioAlbums = !empty($request->AudioAlbums) ?  "1" : "0" ;
        $settings->my_playlist = !empty($request->my_playlist) ?  "1" : "0" ;
        $settings->video_playlist = !empty($request->video_playlist) ?  "1" : "0" ;
        $settings->Today_Top_videos = !empty($request->Today_Top_videos) ?  "1" : "0" ;
        $settings->series_episode_overview = !empty($request->series_episode_overview) ?  "1" : "0" ;
        $settings->Series_Networks = !empty($request->Series_Networks) ?  "1" : "0" ;
        $settings->Series_based_on_Networks = !empty($request->Series_based_on_Networks) ?  "1" : "0" ;
        $settings->Leaving_soon_videos = !empty($request->Leaving_soon_videos) ?  "1" : "0" ;
        $settings->Document = !empty($request->Document) ?  "1" : "0" ;
        $settings->Document_Category = !empty($request->Document_Category) ?  "1" : "0" ;
        $settings->watchlater_videos = !empty($request->watchlater_videos) ?  "1" : "0" ;
        $settings->wishlist_videos = !empty($request->wishlist_videos) ?  "1" : "0" ;
        $settings->latest_episode_videos = !empty($request->latest_episode_videos) ?  "1" : "0" ;
        $settings->epg = !empty($request->epg) ?  "1" : "0" ;
        $settings->live_artist = !empty($request->live_artist) ?  "1" : "0" ;
        $settings->user_generated_content = !empty($request->user_generated_content) ?  "1" : "0" ;
        $settings->shorts_minis = !empty($request->shorts_minis) ?  "1" : "0" ;
        $settings->radio_station = !empty($request->radio_station) ?  "1" : "0" ;

        $settings->web_pagination_count = !empty($request['web_pagination_count']) ? $request['web_pagination_count'] : '3';

        $settings->save();
        
        return redirect::to('/admin/home-settings');
    }



    public function Orderindex(){
        
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
        }else{
        $order_settings = OrderHomeSetting::orderBy('order_id', 'asc')->get();  
        // dd($order_settings); 
        $data = array(
            "order_settings" =>$order_settings 
        );
        return view('admin.settings.order_homepage',$data);
    }
    }
    public function OrderEdit_settings($id){

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
        }else{
        return View::make('admin.settings.order_edit_homepage', array('order_settings' => OrderHomeSetting::find($id)));
        }
    }


    public function OrderDelete_settings($id){
        OrderHomeSetting::destroy($id);
         return Redirect::to('admin/home-settings')->with(array('note' => 'Successfully Deleted Menu Item', 'note_type' => 'success') );
    }

    public function OrderUpdate(Request $request){
        $input = $request->all();
        $menu = OrderHomeSetting::find($input['id'])->update($input);
        if(isset($menu)){
            return Redirect::to('admin/home-settings')->with(array('note' => 'Successfully Updated Category', 'note_type' => 'success') );
        }
    }

    public function OrderUpdate_settings(Request $request){

        $post_categories = OrderHomeSetting::all();


        foreach ($post_categories as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['order_id' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    

    }

    public function mobilesave_settings(Request $request){
        
        $settings = MobileHomeSetting::first();

        if(!empty($request['featured_videos'])){
            $settings->featured_videos = 1;
        } 
        if(empty($request['featured_videos'])){
            $settings->featured_videos = 0;
        } 

        if(!empty($request['latest_videos'])){
            $settings->latest_videos = 1;
        } 
        if(empty($request['latest_videos'])){
            $settings->latest_videos = 0;
        } 

        if(!empty($request['category_videos'])){
            $settings->category_videos = 1;
        } 
        if(empty($request['category_videos'])){
            $settings->category_videos = 0;
        } 
        if(!empty($request['live_videos'])){
            $settings->live_videos = 1;
        } 
        if(empty($request['live_videos'])){
            $settings->live_videos = 0;
        } 
        if(!empty($request['audios'])){
            $settings->audios = 1;
        } 
        if(empty($request['audios'])){
            $settings->audios = 0;
        } 
        if(!empty($request['albums'])){
            $settings->albums = 1;
        } 
        if(empty($request['albums'])){
            $settings->albums = 0;
        } 
        if($request['series'] == null){
            $settings->series = 0;
        }else{
            $settings->series = 1;
        } 

        if($request->Recommendation !=null){
            $settings->Recommendation = 1;
        }else{
            $settings->Recommendation = 0;
        }

        if($request->live_category !=null){
            $settings->live_category = 1;
        }else{
            $settings->live_category = 0;
        }
        
        if($request->AutoIntro_skip !=null){
            $settings->AutoIntro_skip = 1;
        }else{
            $settings->AutoIntro_skip = 0;
        }
        $settings->video_schedule = !empty($request->video_schedule) ?  "1" : "0" ;
        $settings->videoCategories = !empty($request->videoCategories) ?  "1" : "0" ;
        $settings->liveCategories = !empty($request->liveCategories) ?  "1" : "0" ;
        $settings->channel_partner = !empty($request->channel_partner) ?  "1" : "0" ;
        $settings->content_partner = !empty($request->content_partner) ?  "1" : "0" ;
        $settings->latest_viewed_Videos = !empty($request->latest_viewed_Videos) ?  "1" : "0" ;
        $settings->latest_viewed_Livestream = !empty($request->latest_viewed_Livestream) ?  "1" : "0" ;
        $settings->latest_viewed_Audios = !empty($request->latest_viewed_Audios) ?  "1" : "0" ;
        $settings->latest_viewed_Episode = !empty($request->latest_viewed_Episode) ?  "1" : "0" ;
        $settings->SeriesGenre = !empty($request->SeriesGenre) ?  "1" : "0" ;
        $settings->SeriesGenre_videos = !empty($request->SeriesGenre_videos) ?  "1" : "0" ;
        $settings->AudioGenre = !empty($request->AudioGenre) ?  "1" : "0" ;
        $settings->AudioGenre_audios = !empty($request->AudioGenre_audios) ?  "1" : "0" ;
        $settings->AudioAlbums = !empty($request->AudioAlbums) ?  "1" : "0" ;
        $settings->Recommended_videos_site = !empty($request->Recommended_videos_site) ?  "1" : "0" ;
        $settings->Recommended_videos_users = !empty($request->Recommended_videos_users) ?  "1" : "0" ;
        $settings->Recommended_videos_Country = !empty($request->Recommended_videos_Country) ?  "1" : "0" ;
        $settings->continue_watching = !empty($request->continue_watching) ?  "1" : "0" ;
        $settings->my_playlist = !empty($request->my_playlist) ?  "1" : "0" ;
        $settings->video_playlist = !empty($request->video_playlist) ?  "1" : "0" ;
        $settings->Today_Top_videos = !empty($request->Today_Top_videos) ?  "1" : "0" ;
        $settings->series_episode_overview = !empty($request->series_episode_overview) ?  "1" : "0" ;
        $settings->Series_Networks = !empty($request->Series_Networks) ?  "1" : "0" ;
        $settings->Series_based_on_Networks = !empty($request->Series_based_on_Networks) ?  "1" : "0" ;
        $settings->Document = !empty($request->Document) ?  "1" : "0" ;
        $settings->Document_Category = !empty($request->Document_Category) ?  "1" : "0" ;
        $settings->watchlater_videos = !empty($request->watchlater_videos) ?  "1" : "0" ;
        $settings->wishlist_videos = !empty($request->wishlist_videos) ?  "1" : "0" ;
        $settings->latest_episode_videos = !empty($request->latest_episode_videos) ?  "1" : "0" ;
        $settings->live_artist = !empty($request->live_artist) ?  "1" : "0" ;
        $settings->epg = !empty($request->epg) ?  "1" : "0" ;
        $settings->radio_station = !empty($request->radio_station) ?  "1" : "0" ;
        $settings->user_generated_content = !empty($request->user_generated_content) ?  "1" : "0" ;

        $settings->mobile_pagination = !empty($request['mobile_pagination']) ? $request['mobile_pagination'] : '3';
        $settings->save();

        return redirect::to('/admin/home-settings');
    }
    public function rokusave_settings(Request $request){
        
        $settings = RokuHomeSetting::first();

        // dd($settings);

        if(!empty($request['featured_videos'])){
            $settings->featured_videos = 1;
        } 
        if(empty($request['featured_videos'])){
            $settings->featured_videos = 0;
        } 

        if(!empty($request['latest_videos'])){
            $settings->latest_videos = 1;
        } 
        if(empty($request['latest_videos'])){
            $settings->latest_videos = 0;
        } 

        if(!empty($request['category_videos'])){
            $settings->category_videos = 1;
        } 
        if(empty($request['category_videos'])){
            $settings->category_videos = 0;
        } 
        if(!empty($request['live_videos'])){
            $settings->live_videos = 1;
        } 
        if(empty($request['live_videos'])){
            $settings->live_videos = 0;
        } 
        if(!empty($request['audios'])){
            $settings->audios = 1;
        } 
        if(empty($request['audios'])){
            $settings->audios = 0;
        } 
        if(!empty($request['albums'])){
            $settings->albums = 1;
        } 
        if(empty($request['albums'])){
            $settings->albums = 0;
        } 
        if($request['series'] == null){
            $settings->series = 0;
        }else{
            $settings->series = 1;
        } 

        if($request->Recommendation !=null){
            $settings->Recommendation = 1;
        }else{
            $settings->Recommendation = 0;
        }

        if($request->live_category !=null){
            $settings->live_category = 1;
        }else{
            $settings->live_category = 0;
        }
        
        if($request->AutoIntro_skip !=null){
            $settings->AutoIntro_skip = 1;
        }else{
            $settings->AutoIntro_skip = 0;
        }
        $settings->video_schedule = !empty($request->video_schedule) ?  "1" : "0" ;
        $settings->videoCategories = !empty($request->videoCategories) ?  "1" : "0" ;
        $settings->liveCategories = !empty($request->liveCategories) ?  "1" : "0" ;
        $settings->channel_partner = !empty($request->channel_partner) ?  "1" : "0" ;
        $settings->content_partner = !empty($request->content_partner) ?  "1" : "0" ;
        $settings->latest_viewed_Videos = !empty($request->latest_viewed_Videos) ?  "1" : "0" ;
        $settings->latest_viewed_Livestream = !empty($request->latest_viewed_Livestream) ?  "1" : "0" ;
        $settings->latest_viewed_Audios = !empty($request->latest_viewed_Audios) ?  "1" : "0" ;
        $settings->latest_viewed_Episode = !empty($request->latest_viewed_Episode) ?  "1" : "0" ;
        $settings->SeriesGenre = !empty($request->SeriesGenre) ?  "1" : "0" ;
        $settings->SeriesGenre_videos = !empty($request->SeriesGenre_videos) ?  "1" : "0" ;
        $settings->AudioGenre = !empty($request->AudioGenre) ?  "1" : "0" ;
        $settings->AudioGenre_audios = !empty($request->AudioGenre_audios) ?  "1" : "0" ;
        $settings->AudioAlbums = !empty($request->AudioAlbums) ?  "1" : "0" ;
        $settings->Recommended_videos_site = !empty($request->Recommended_videos_site) ?  "1" : "0" ;
        $settings->Recommended_videos_users = !empty($request->Recommended_videos_users) ?  "1" : "0" ;
        $settings->Recommended_videos_Country = !empty($request->Recommended_videos_Country) ?  "1" : "0" ;
        $settings->continue_watching = !empty($request->continue_watching) ?  "1" : "0" ;
        $settings->my_playlist = !empty($request->my_playlist) ?  "1" : "0" ;
        $settings->video_playlist = !empty($request->video_playlist) ?  "1" : "0" ;
        $settings->Today_Top_videos = !empty($request->Today_Top_videos) ?  "1" : "0" ;
        $settings->series_episode_overview = !empty($request->series_episode_overview) ?  "1" : "0" ;
        $settings->Series_Networks = !empty($request->Series_Networks) ?  "1" : "0" ;
        $settings->Series_based_on_Networks = !empty($request->Series_based_on_Networks) ?  "1" : "0" ;
        $settings->Document = !empty($request->Document) ?  "1" : "0" ;
        $settings->Document_Category = !empty($request->Document_Category) ?  "1" : "0" ;
        $settings->watchlater_videos = !empty($request->watchlater_videos) ?  "1" : "0" ;
        $settings->wishlist_videos = !empty($request->wishlist_videos) ?  "1" : "0" ;
        $settings->latest_episode_videos = !empty($request->latest_episode_videos) ?  "1" : "0" ;
        $settings->live_artist = !empty($request->live_artist) ?  "1" : "0" ;
        $settings->epg = !empty($request->epg) ?  "1" : "0" ;
        // $settings->radio_station = !empty($request->radio_station) ?  "1" : "0" ;
        // $settings->user_generated_content = !empty($request->user_generated_content) ?  "1" : "0" ;

        // $settings->mobile_pagination = !empty($request['mobile_pagination']) ? $request['mobile_pagination'] : '3';
        $settings->save();

        return redirect::to('/admin/home-settings');
    }
}