<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Series as Series;
use \App\User as User;
use \App\Genre as Genre;
use App\Episode as Episode;
use App\Setting as Setting;
use \App\SeriesSeason as SeriesSeason;
// use \App\Tag as Tag;
use \Redirect as Redirect;
use URL;
use App\Test as Test;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\AgeCategory as AgeCategory;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\ConvertEpisodeVideo;
use App\Jobs\Convert4kEpisodeVideo;
use App\Jobs\ConvertEpisodeVideoWatermark;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Seriesartist;
use GifCreator\GifCreator;
use FFMpeg\Coordinate\TimeCode;
use App\SeriesCategory as SeriesCategory;
use App\SeriesLanguage as SeriesLanguage;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\SeriesGenre;
use App\Jobs\ConvertSerieTrailer;
use Streaming\Representation;
use getID3;
use App\InappPurchase;
use App\Channel as Channel;
use App\ModeratorsUser as ModeratorsUser;
use App\StorageSetting as StorageSetting;
use App\Advertisement;
use App\Playerui as Playerui;
use App\SeriesSubtitle as SeriesSubtitle;
use App\SeriesNetwork;
use App\Adscategory;
use App\VideoExtractedImages;
use App\SiteTheme;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\CompressImage;
use App\CountryCode;
use Illuminate\Support\Facades\DB; 
use App\DeleteLog;


class AdminSeriesController extends Controller
{
     /**
     * Display a listing of series
     *
     * @return Response
     */

    public function __construct()
    {
        $this->Enable_Flussonic_Upload = Enable_Flussonic_Upload();
        $this->Enable_Flussonic_Upload_Details = Enable_Flussonic_Upload_Details();
        $this->Flussonic_Auth_Key  = $this->Enable_Flussonic_Upload_Details->flussonic_storage_Auth_Key;
        $this->Flussonic_Server_Base_URL  = $this->Enable_Flussonic_Upload_Details->flussonic_storage_site_base_url;
        $this->Flussonic_Storage_Tag  = $this->Enable_Flussonic_Upload_Details->flussonic_storage_tag;

    }

    public function index(Request $request)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
         if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
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
            }else{

          $search_value = $request->get('s');
        
            $series = Series::latest()->get();
        
        $user = Auth::user();

        $data = array(
            'series' => $series,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.series.index', $data);
            }
    }

    /**
     * Show the form for creating a new series
     *
     * @return Response
     */
    public function create()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $settings  = Setting::first();

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
        }else{
            $compress_image_settings = CompressImage::first();
            $data = array(
                'settings ' => $settings,
                'headline' => '<i class="fa fa-plus-circle"></i> New Series',
                'post_route' => URL::to('admin/series/store'),
                'button_text' => 'Add New TV Shows',
                'admin_user' => Auth::user(),
                'series_categories' => SeriesGenre::all(),
                'video_categories' => VideoCategory::all(),
                'languages' => Language::all(),
                'artists' => Artist::all(),
                'series_artist' => [],
                'category_id' => [],
                'languages_id' => [],
                'series_networks_id' => [],
                'InappPurchase' => InappPurchase::all(),
                'SeriesNetwork' => SeriesNetwork::all(),
                'Header_name' => "Edit TV Shows ",
                'compress_image_settings' =>  $compress_image_settings,
                "countries"      => CountryCode::all(),
            );

           return View::make('admin.series.create_edit', $data);
        }
    }

    /**
     * Store a newly created series in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => ['required', 'string'],
        ]);

        
         /*Slug*/
        $data = $request->all();

        $countryNames = isset($data['country']) ? $data['country'] : [];

        $countryIds = [];
        if (!empty($countryNames)) {
            $countryIds = CountryCode::whereIn('country_name', $countryNames)->pluck('id')->toArray();
        }
        $countryIds = CountryCode::whereIn('country_name', $countryNames)->pluck('id')->toArray();
        // dd($countryIds);

        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
        }

        if(!empty($data['genre_id'])){
            $genre_iddata = $data['genre_id'];
            unset($data['genre_id']);
        }

        if(!empty($data['language'])){
            $languagedata = $data['language'];
            unset($data['language']);
        }

        $path = public_path().'/uploads/videos/';
        $image_path = public_path().'/uploads/images/';
        
        // Series Image 

            $image = (isset($data['image'])) ? $data['image'] : '';

            if(!empty($image)){

                if($image != ''  && $image != null){
                       $file_old = $image_path.$image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }

                $file = $image;

                if(compress_image_enable() == 1){
    
                    $series_filename  = time().'.'.compress_image_format();
                    $series_image     =  'series-'.$series_filename ;
                    Image::make($file)->save(public_path('uploads/images/'.$series_image),compress_image_resolution() );
                }else{
    
                    $series_filename  = time().'.'.$image->getClientOriginalExtension();
                    $series_image     =  'series-'.$series_filename ;
                    Image::make($file)->save(public_path('uploads/images/'.$series_image) );
                }  

                $data['image'] = $series_image;

            } else {
                $data['image'] = default_vertical_image();
            }
        
            // Series Player Image  

            $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

            if(!empty($player_image) && $data['player_image'] != 'validate'){

                if($player_image != ''  && $player_image != null){
                       $file_old = $image_path.$player_image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  $player_image = $player_image;

                if(compress_image_enable() == 1){
    
                    $series_playerimage_filename  = time().'.'.compress_image_format();
                    $series_playerimage_image     =  'series_playerimage_'.$series_playerimage_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$series_playerimage_image,compress_image_resolution() );
                }else{
    
                    $series_playerimage_filename  = time().'.'.$player_image->getClientOriginalExtension();
                    $series_playerimage_image     =  'series_playerimage_'.$series_playerimage_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$series_playerimage_image );
                }  

                $player_image  =  $series_playerimage_image ; 

            } else {

                $player_image = default_vertical_image();

            }

            // Series TV  Image  

            $tv_image = (isset($data['tv_image'])) ? $data['tv_image'] : '';

            if(!empty($tv_image) && $data['tv_image'] != 'validate'){

                if($tv_image != ''  && $tv_image != null){
                       $file_old = $image_path.$tv_image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  $tv_image = $tv_image;

                if(compress_image_enable() == 1){
    
                    $series_tv_image_filename  = time().'.'.compress_image_format();
                    $series_tv_image_image     =  'series_tv_image_'.$series_tv_image_filename ;
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$series_tv_image_image,compress_image_resolution() );
                }else{
    
                    $series_tv_image_filename  = time().'.'.$tv_image->getClientOriginalExtension();
                    $series_tv_image_image     =  'series_tv_image_'.$series_tv_image_filename ;
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$series_tv_image_image );
                }  

                $tv_image  =  $series_tv_image_image ; 

            } else {
                $tv_image = default_horizontal_image();
            }

            if (compress_responsive_image_enable() == 1 || compress_responsive_image_enable() == 0) {
                
                if ($request->hasFile('image')) {

                    $local_image_path = public_path('/uploads/images/' . basename($data['image']));
                    // dd(file_exists($local_image_path));
                    if (file_exists($local_image_path)) {
                        $image = Image::make($local_image_path);
                        $image_filename = 'series_' . time() . '_image.webp';
                        // dd($image_filename); 
                    } 
                    // dd($image_filename);
                    Image::make($image)->resize(187,332)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(244,435)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(198,351)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                    
                    $responsive_image = $image_filename;
                    
                }else{
                    $responsive_image = default_vertical_image();  
                }

                if ($request->hasFile('player_image')) {

                    $local_image_path = public_path('/uploads/images/' . basename($player_image));
                    // dd(file_exists($local_image_path));
                    if (file_exists($local_image_path)) {
                        $series_player_image = Image::make($local_image_path);
                        $player_image_filename = 'series_' . time() . '_player_image.webp';
                        // dd($image_filename); 
                    } 
                    // dd($player_image_filename);
                    Image::make($series_player_image)->resize(332,187)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                    Image::make($series_player_image)->resize(435,244)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                    Image::make($series_player_image)->resize(351,198)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                    
                    $player_responsive_image = $player_image_filename;
                    
        
                }else{
        
                    $player_responsive_image = default_horizontal_image();
                }
            }
            
//          
//         if($image != '') {   
//              //code for remove old file
//              if($image != ''  && $image != null){
//                   $file_old = $image_path.$image;
//                  if (file_exists($file_old)){
//                   unlink($file_old);
//                  }
//              }
//              //upload new file
//              $file = $image;
//              $data['image']  = $file->getClientOriginalName();
//              $file->move($image_path, $data['image']);
//
//         } 
        

//        $tags = $data['tags'];
//        unset($data['tags']);
        
        if(empty($data['active'])){
            $data['active'] = 0;
        }


        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        $data['title'] = $data['title'];
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        $data['network_id'] = !empty($data['network_id']) ? json_encode($data['network_id']) : null ;
          
        $series = Series::create($data);
        
        if(!empty($data['ppv_status'])){

            $ppv_status = $data['ppv_status'];
            $access = 'ppv';

        }else{
            $ppv_status = 0;
            $access = $data['access'];
        }

        if(!empty($data['season_trailer'])){

            $season_trailer = $data['season_trailer'];
        }else{
            $season_trailer = null;
        }

        if(!empty($data['series_trailer'])){

            $series_trailer = $data['series_trailer'];
        }else{
            $series_trailer = 0;
        }

        if( $request->slug == ''){

            $slug = Series::where('slug',$request->title)->first();

            $series_slug  = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $request->title )  : preg_replace("![^a-z0-9]+!i", "-",  $request->title.'-'.$series->id ) ;

        }else{

            $slug = Series::where('slug',$request->slug)->first();

            $series_slug  = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $request->slug )  : preg_replace("![^a-z0-9]+!i", "-",  $request->slug.'-'.$series->id ) ;
        }

        $series = Series::find($series->id);
        $series->slug = $series_slug;
        $series->ppv_status = $ppv_status;
        $series->ppv_status = $access;
        $series->player_image = $player_image;
        $series->tv_image = $tv_image;
        $series->banner = empty($data['banner']) ? 0 : 1;
        $series->search_tag =$data['search_tag'];
        $series->details =($data['details']);
        $series->season_trailer = $season_trailer ;
        $series->series_trailer = $series_trailer ;
        $series->blocked_countries = json_encode($countryIds);
        $series->responsive_image = $responsive_image ;
        $series->player_responsive_image = $player_responsive_image ;
        $series->save();  


        if(!empty($artistsdata)){
            foreach ($artistsdata as $key => $value) {
                $artist = new Seriesartist;
                $artist->series_id =  $series->id;
                $artist->artist_id = $value;
                $artist->save();
            }
        }

            /*save artist*/
            if(!empty($genre_iddata)){
                SeriesCategory::where('series_id', $series->id)->delete();
                foreach ($genre_iddata as $key => $value) {
                    $category = new SeriesCategory;
                    $category->series_id = $series->id;
                    $category->category_id = $value;
                    $category->save();
                }
            }
        

            /*save artist*/
            if(!empty($languagedata)){
                SeriesLanguage::where('series_id', $series->id)->delete();
                foreach ($languagedata as $key => $value) {
                    $serieslanguage = new SeriesLanguage;
                    $serieslanguage->series_id = $series->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }
            }
        
       // $this->addUpdateSeriesTags($series, $tags);

        $resolution_data['series_id'] = $series->id;
        $subtitle_data['series_id'] = $series->id;
        
        $series_upload = $request->file('series_upload');

        if($series_upload) {

         $rand = Str::random(16);
                $path = $rand . '.' . $request->series_upload->getClientOriginalExtension();
            //print_r($path);exit;
                $request->series_upload->storeAs('public', $path);
                $data['mp4_url'] = $path;
            
        
        $update_url = Series::find($resolution_data['series_id']);

      
        $update_url->mp4_url = $data['mp4_url'];
        $update_url->slug = $data['slug'];
        $update_url->mp4_url = $ppv_status;


        $update_url->save();  


     
        }
// dd($data['network_id']);
    if(!empty($data['network_id'])){
        $networkIds = json_decode($data['network_id'], true);

        if (is_array($networkIds)) {
            foreach ($networkIds as $networkId) {
                // Check if the combination of series_id and network_id already exists
                $exists = DB::table('series_network_order')
                    ->where('series_id', $series->id)
                    ->where('network_id', $networkId)
                    ->exists();

                if (!$exists) {
                    $maxOrder = DB::table('series_network_order')
                        ->where('network_id', $networkId)
                        ->max('order');

                    $nextOrder = $maxOrder ? $maxOrder + 1 : 1;

                    DB::table('series_network_order')->insert([
                        'series_id' => $series->id,    
                        'network_id' => $networkId,
                        'order' => $nextOrder,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } else {
            throw new Exception("Invalid network_id format. Expected a JSON array.");
        }
    }

        
        /*Subtitle Upload*/
        // $files = $request->file('subtitle_upload');
        $shortcodes = $request->get('short_code');
        $languages = $request->get('language');

        return Redirect::to('admin/series-list')->with(array('note' => 'New Series Successfully Added!', 'note_type' => 'success') );
    }

    /**
     * Show the form for editing the specified series.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        
            $series = Series::find($id);
            $results = Episode::all();
            $settings  = Setting::first();

            $compress_image_settings = CompressImage::first();

            if ($series && isset($series->blocked_countries)) {
                $blockedCountries = json_decode($series->blocked_countries, true);
            } else {
                $blockedCountries = [];
            }
            // $blockedCountries = json_decode($series->blocked_countries, true);

            $blcok_CountryName = CountryCode::whereIn('id', (!empty($blockedCountries) ? $blockedCountries : []))->pluck('country_name')->toArray();

            // dd($blockedCountries);

            //$episode = Episode::all();
            $seasons = SeriesSeason::orderBy('order')->where('series_id','=',$id)->with('episodes')->get()
                                    ->map(function($item){
                                        $item['total_episode']= Episode::where('season_id',$item->id)->count();
                                        $item['active_episode']= Episode::where('season_id',$item->id)->where('active',1)->count();
                                        // $item['draft_episodes']= Episode::where('season_id',$item->id)->where('active',0)->count();
                                        $item['draft_episodes'] = Episode::where('season_id', $item->id)->where(function ($query) {$query->where('active', '=', 0)->orWhereNull('active');})->count();
                                        return $item;
                                    });

            // $books = SeriesSeason::with('episodes')->get();   
                    // dd(SeriesLanguage::where('series_id', $id)->pluck('language_id')->toArray());
            $season_ids = SeriesSeason::where('series_id', $id)->pluck('id');
            $unassigned_episodes = Episode::where('series_id',$id)->whereNotIn('season_id', $season_ids)->get();
            // dd($seasons);
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Series',
            'series' => $series,
            'settings' => $settings,
            'seasons' => $seasons,
            'post_route' => URL::to('admin/series/update'),
            'button_text' => 'Update TV Shows',
            'admin_user' => Auth::user(),
            'series_categories' => SeriesGenre::all(),
            'videos_categories' => VideoCategory::all(),
            'languages' => Language::all(),
            'artists' => Artist::all(),
            'series_artist' => Seriesartist::where('series_id', $id)->pluck('artist_id')->toArray(),
            'category_id'   => SeriesCategory::where('series_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => SeriesLanguage::where('series_id', $id)->pluck('language_id')->toArray(),
            'InappPurchase' => InappPurchase::all(),
            'SeriesNetwork' => SeriesNetwork::all(),
            'series_networks_id' => !empty($series->network_id) ? json_decode($series->network_id): [],
            'Header_name' => "Edit TV Shows ",
            'compress_image_settings' => $compress_image_settings,
            'theme_settings' => SiteTheme::first(),
            "countries"      => CountryCode::all(),
            "blcok_CountryName" => $blcok_CountryName,
            "unassigned_episodes" => $unassigned_episodes,
            );

        return View::make('admin.series.create_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $series = Series::findOrFail($id);

        $data = $input;

        $countryNames = isset($data['country']) ? $data['country'] : [];

        $countryIds = [];
        if (!empty($countryNames)) {
            $countryIds = CountryCode::whereIn('country_name', $countryNames)->pluck('id')->toArray();
        }
        $countryIds = CountryCode::whereIn('country_name', $countryNames)->pluck('id')->toArray();
        // dd($countryIds);

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        if(  $data['slug']  == '' ){

            $slug = Series::whereNotIn('id',[$id])->where('slug',$data['title'])->first();

            $data['slug']  = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $data['title'] )  : preg_replace("![^a-z0-9]+!i", "-",  $data['title'].'-'.$id ) ;
        }else{

            $slug = Series::whereNotIn('id',[$id])->where('slug',$data['slug'])->first();

            $data['slug']  = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $data['slug'] )  : preg_replace("![^a-z0-9]+!i", "-",  $data['slug'].'-'.$id ) ;
        }

        $path = public_path().'/uploads/videos/';
        $image_path = public_path().'/uploads/images/';
        
        $image = (isset($data['image'])) ? $data['image'] : '';

            if(!empty($image)){
                if($image != ''  && $image != null){
                       $file_old = $image_path.$image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                }

                $file = $image;

                if(compress_image_enable() == 1){
    
                    $series_filename  = time().'.'.compress_image_format();
                    $series_image     =  'series_'.$series_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$series_image,compress_image_resolution() );
                }else{
    
                    $series_filename  = time().'.'.$image->getClientOriginalExtension();
                    $series_image     =  'series_'.$series_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$series_image );
                }  

                $data['image'] =  $series_image;

            } else {
                $data['image'] = $series->image;
            }

        $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

            if(!empty($player_image) && $data['player_image'] != 'validate'){

                if($player_image != ''  && $player_image != null){
                    $file_old = $image_path.$player_image;
                    if (file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                if(compress_image_enable() == 1){
    
                    $series_playerimage_filename  = time().'.'.compress_image_format();
                    $series_playerimage_image     =  'series_playerimage_'.$series_playerimage_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$series_playerimage_image,compress_image_resolution() );
                }else{
    
                    $series_playerimage_filename  = time().'.'.$player_image->getClientOriginalExtension();
                    $series_playerimage_image     =  'series_playerimage_'.$series_playerimage_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$series_playerimage_image );
                }  

                $player_image = $series_playerimage_image;

               } else {
                $player_image = $series->player_image;
               }

            if($request->hasFile('tv_image')){

                if (File::exists(base_path('public/uploads/images/'.$series->tv_image))) {
                    File::delete(base_path('public/uploads/images/'.$series->tv_image));
                }

                $tv_image = $request->tv_image;
    
                if(compress_image_enable() == 1){
    
                    $Series_tv_filename   = 'Series-TV-Image'.time().'.'. compress_image_format();
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Series_tv_filename , compress_image_resolution() );
    
                }else{
    
                    $Series_tv_filename   = 'Series-TV-Image'.time().'.'.$tv_image->getClientOriginalExtension();
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Series_tv_filename );
                }

                $series->tv_image = $Series_tv_filename;
            }
        //    dd($data);
            if (compress_responsive_image_enable() == 1 || compress_responsive_image_enable() == 0) {
                
                if ($request->hasFile('image') || !empty($data["image"])) {

                    $image = !empty($request->file('image')) ? $request->file('image') : $data["image"];
                    $local_image_path = public_path('/uploads/images/' . basename($data['image']));
                    // dd(file_exists($local_image_path));
                    if (file_exists($local_image_path)) {
                        $image = Image::make($local_image_path);
                        $image_filename = 'series_' . time() . '_image.webp';
                        // dd($image_filename); 
                    } 
                    // dd($image_filename);
                    Image::make($image)->resize(187,332)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(244,435)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(198,351)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                    
                    $responsive_image = $image_filename;
                    
                }else if (!empty($request->responsive_image)) {
                    $responsive_image  = $request->responsive_image;
                } else{
                    $responsive_image = $data->responsive_image; 
                }

                if ($request->hasFile('player_image') || !empty($data["player_image"])) {
                    $responsive_player_image =  $data["player_image"];
                    $player_image_filename = 'series_' . time() . '_player_image.webp';
                    // dd($player_image_filename);
                    Image::make($responsive_player_image)->resize(332,187)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                    Image::make($responsive_player_image)->resize(435,244)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                    Image::make($responsive_player_image)->resize(351,198)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                    
                    $player_responsive_image = $player_image_filename;
                    // dd($player_responsive_image);
                    
                }else if (!empty($request->player_responsive_image)) {
                    $player_responsive_image  = $request->player_responsive_image;
                } else{
                    $player_responsive_image = $player_image; 
                }
            }


        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        
        $series_upload = $request->file('series_upload');
        $resolution_data['series_id'] = $series->id;
        $subtitle_data['series_id'] = $series->id;
        
        if($series_upload) {

                $rand = Str::random(16);
                $path = $rand . '.' . $request->series_upload->getClientOriginalExtension();
            //print_r($path);exit;
                $request->series_upload->storeAs('public', $path);
                $data['mp4_url'] = $path;
            
                $update_url = Series::find($resolution_data['series_id']);

                $update_url->mp4_url = $data['mp4_url'];
                $update_url->search_tag =$data['search_tag'];
                $update_url->save();  
        }

        if(!empty($data['season_trailer'])){

            $season_trailer = $data['season_trailer'];
        }else{
            $season_trailer = null;
        }

        if(!empty($data['series_trailer'])){

            $series_trailer = $data['series_trailer'];
        }else{
            $series_trailer = 0;
        }
        if(!empty($data['ppv_status']) && $data['ppv_status'] == 1){
            $access = 'ppv';
        }else{
            $access = $data['access'];

        }
        // dd($data);
        $series->season_trailer = $season_trailer ;
        $series->series_trailer = $series_trailer ;
        $series->player_image = $player_image;
        $series->banner = empty($data['banner']) ? 0 : 1;
        $series->update($data);
        if(empty($data['ppv_status'])){
            $ppv_status = 0;
        }else{
            $ppv_status = 1;
        }
        $series->player_image = $player_image;
        $series->slug = $data['slug'];
        $series->access = $access;
        $series->ppv_status = $ppv_status;
        $series->details =($data['details']);
        $series->network_id = !empty($data['network_id']) ? json_encode($data['network_id']) : [];
        $series->blocked_countries = json_encode($countryIds);
        $series->responsive_image = $responsive_image;
        $series->player_responsive_image = $player_responsive_image;
        $series->save();

        if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
            /*save artist*/
            if(!empty($artistsdata)){
                Seriesartist::where('series_id', $series->id)->delete();
                foreach ($artistsdata as $key => $value) {
                    $artist = new Seriesartist;
                    $artist->series_id = $series->id;
                    $artist->artist_id = $value;
                    $artist->save();
                }

            }
        }
        if(!empty($data['genre_id'])){
            $category_id = $data['genre_id'];
            unset($data['genre_id']);
            /*save artist*/
            if(!empty($category_id)){
                SeriesCategory::where('series_id', $series->id)->delete();
                foreach ($category_id as $key => $value) {
                    $category = new SeriesCategory;
                    $category->series_id = $series->id;
                    $category->category_id = $value;
                    $category->save();
                }

            }
        }else{
            SeriesCategory::where('series_id', $series->id)->delete();
        }
        if(!empty($data['language'])){
            $language_id = $data['language'];
            unset($data['language']);
            /*save artist*/
            if(!empty($language_id)){
                SeriesLanguage::where('series_id', $series->id)->delete();
                foreach ($language_id as $key => $value) {
                    $serieslanguage = new SeriesLanguage;
                    $serieslanguage->series_id = $series->id;
                    $serieslanguage->language_id = $value;
                    $serieslanguage->save();
                }

            }
        }
        
        if(empty($data['series_upload'])){
            unset($data['series_upload']);
        } 

          /*Subtitle Upload*/
        $files = $request->file('subtitle_upload');
        $shortcodes = $request->get('short_code');
        $languages = $request->get('language');

        if($request->hasFile('subtitle_upload'))
        {
            foreach ($files as $key => $val) {
                if(!empty($files[$key])){
                    
                    $destinationPath ='content/uploads/subtitles/';
                    $filename = $id. '-'.$shortcodes[$key].'.vtt';
                    $files[$key]->move($destinationPath, $filename);
                    $subtitle_data['sub_language'] = $languages[$key]; 
                    $subtitle_data['series_id'] = $id; 
                    $subtitle_data['shortcode'] = $shortcodes[$key]; 
                    $subtitle_data['url'] = URL::to('/').'/content/uploads/subtitles/'.$filename; 
                    $series_subtitle = SeriesSubtitle::updateOrCreate(array('shortcode' => 'en','series_id' => $id), $subtitle_data);
                }
            }
        }
        $networkIds = !empty($data['network_id']) ? $data['network_id'] : NULL;
        // dd(!empty($networkIds));
        if(!empty($networkIds)){
            DB::table('series_network_order')
                ->where('series_id', $data['id'])
                ->whereNotIn('network_id', $networkIds)
                ->delete();

            // Step 2: Iterate through the current network IDs and insert missing rows
            foreach ($networkIds as $networkId) {
                // Check if the combination of series_id and network_id already exists
                $exists = DB::table('series_network_order')
                    ->where('series_id', $data['id'])
                    ->where('network_id', $networkId)
                    ->exists();

                // If it doesn't exist, insert a new record
                if (!$exists) {
                    // Find the max order for the current network_id
                    $maxOrder = DB::table('series_network_order')
                        ->where('network_id', $networkId)
                        ->max('order');

                    // Calculate the next order number (max + 1)
                    $nextOrder = $maxOrder ? $maxOrder + 1 : 1;

                    // Insert a new record into the series_network_order table
                    DB::table('series_network_order')->insert([
                        'series_id' => $data['id'],
                        'network_id' => $networkId,
                        'order' => $nextOrder,
                        'created_at' => now(), 
                        'updated_at' => now()
                    ]);
                }
            }
        }else{
            DB::table('series_network_order')
                ->where('series_id', $data['id'])
                ->delete();
        }



        return Redirect::to('admin/series/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Series!', 'note_type' => 'success') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
        
            $series = Series::find($id);
            
            $Seasons_depend_series = $series->Series_depends_seasons->pluck('id'); 

            // dd(Auth::user()->id);
            DeleteLog::create([
                'series_id'       => $series->id,
                'user_id'         => Auth::user()->id,
                'deleted_item'    => 'series',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Seasons depend series

            foreach($Seasons_depend_series as $season_id ){

                    $season   = SeriesSeason::find($season_id);

                        //  Delete Existing Image - Season
                    $season_image = basename($season->image);

                    if (File::exists(base_path('public/uploads/season_images/'.$season_image))) {
                        File::delete(base_path('public/uploads/season_images/'.$season_image));
                    }

                            //  Delete Existing Trailer - Season

                    $vseason_trailer = pathinfo($season->trailer)['filename'];

                    $directory = base_path('storage/app/season_trailer/');
                            
                    $pattern =  $vseason_trailer.'*';

                    $files = glob($directory . $pattern);

                    foreach ($files as $file) {
                        if (File::exists($file) && File::isFile($file)) {
                            File::delete($file);
                        }
                    }
                
                    SeriesSeason::destroy($id);
                }

            // Episode depend series

            $Episode_depend_series = $series->Series_depends_episodes->pluck('id'); 

                foreach($Episode_depend_series as $episode_id ){

                    $Episode   = Episode::find($episode_id);

                            //  Delete Existing  Image
                    if (File::exists(base_path('public/uploads/images/'.$Episode->image))) {
                        File::delete(base_path('public/uploads/images/'.$Episode->image));
                    }

                            //  Delete Existing Player Image
                    if (File::exists(base_path('public/uploads/images/'.$Episode->player_image))) {
                        File::delete(base_path('public/uploads/images/'.$Episode->player_image));
                    }

                            //  Delete Existing  Tv Image
                    if (File::exists(base_path('public/uploads/images/'.$Episode->tv_image))) {
                        File::delete(base_path('public/uploads/images/'.$Episode->tv_image));
                    }

                            //  Delete Existing  Episode
                    $directory = storage_path('app/public');

                    $info = pathinfo($Episode->mp4_url);
                
                    $pattern =  $info['filename'] . '*';
                
                    $files = glob($directory . '/' . $pattern);
                
                    foreach ($files as $file) {
                        unlink($file);
                    }

                    Episode::destroy($episode_id);
                }

            // series

            $series = Series::find($id);

                        //  Delete Existing  Image
                if (File::exists(base_path('public/uploads/images/'.$series->image))) {
                    File::delete(base_path('public/uploads/images/'.$series->image));
                }

                        //  Delete Existing Player  Image
                if (File::exists(base_path('public/uploads/images/'.$series->player_image))) {
                    File::delete(base_path('public/uploads/images/'.$series->player_image));
                }

                        //  Delete Existing Tv Image
                if (File::exists(base_path('public/uploads/images/'.$series->tv_image))) {
                    File::delete(base_path('public/uploads/images/'.$series->tv_image));
                }
        
            Series::destroy($id);
            Seriesartist::where('series_id',$id)->delete();
            SeriesSubtitle::where('series_id', $id)->delete();
            SeriesLanguage::where('series_id',$id)->delete();
            SeriesCategory::where('series_id',$id)->delete();

            return Redirect::to('admin/series-list')->with(array('note' => 'Successfully Deleted Series', 'note_type' => 'success') );
    
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    private function addUpdateSeriesTags($series, $tags){
        $tags = array_map('trim', explode(',', $tags));


        foreach($tags as $tag){
            
            $tag_id = $this->addTag($tag);
            $this->attachTagToSeries($series, $tag_id);
        }  

        // Remove any tags that were removed from series
        foreach($series->tags as $tag){
            if(!in_array($tag->name, $tags)){
                $this->detachTagFromSeries($series, $tag->id);
                if(!$this->isTagContainedInAnySeries($tag->name)){
                    $tag->delete();
                }
            }
        }
    }

    /**************************************************
    /*
    /*  PRIVATE FUNCTION
    /*  addTag( tag_name )
    /*
    /*  ADD NEW TAG if Tag does not exist
    /*  returns tag id
    /*
    /**************************************************/

    private function addTag($tag){
        $tag_exists = Tag::where('name', '=', $tag)->first();
            
        if($tag_exists){ 
            return $tag_exists->id; 
        } else {
            $new_tag = new Tag;
            $new_tag->name = strtolower($tag);
            $new_tag->save();
            return $new_tag->id;
        }
    }

    /**************************************************
    /*
    /*  PRIVATE FUNCTION
    /*  attachTagToSeries( series object, tag id )
    /*
    /*  Attach a Tag to a Series
    /*
    /**************************************************/

    private function attachTagToSeries($series, $tag_id){
        // Add New Tags to series
        if (!$series->tags->contains($tag_id)) {
            $series->tags()->attach($tag_id);
        }
    }

    private function detachTagFromSeries($series, $tag_id){
        // Detach the pivot table
        $series->tags()->detach($tag_id);
    }

    public function isTagContainedInAnySeries($tag_name){
        // Check if a tag is associated with any series
        $tag = Tag::where('name', '=', $tag_name)->first();
        return (!empty($tag) && $tag->videos->count() > 0) ? true : false;
    }

    private function deleteSeriesImages($series){
        $ext = pathinfo($series->image, PATHINFO_EXTENSION);
        if(file_exists('public/uploads/images/' . $series->image) && $series->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . $series->image);
        }

        if(file_exists('public/uploads/images/' . str_replace('.' . $ext, '-large.' . $ext, $series->image) )  && $series->image != 'placeholder.jpg'){
            @unlink('public/uploads/images/' . str_replace('.' . $ext, '-large.' . $ext, $series->image) );
        }

        if(file_exists('public/uploads/images/' . str_replace('.' . $ext, '-medium.' . $ext, $series->image) )  && $series->image != 'placeholder.jpg'){
            @unlink('public/uploads/images/' . str_replace('.' . $ext, '-medium.' . $ext, $series->image) );
        }

        if(file_exists('public/uploads/images/' . str_replace('.' . $ext, '-small.' . $ext, $series->image) )  && $series->image != 'placeholder.jpg'){
            @unlink('public/uploads/images/' . str_replace('.' . $ext, '-small.' . $ext, $series->image) );
        }
    }
    
    public function create_season(Request $request)
    {

        $data = $request->all();
        $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
        $image = (isset($data['image'])) ? $data['image'] : '';
        

        $settings = Setting::first();

        $package = User::where('id',1)->first();
        $pack = $package->package;

        if($settings->transcoding_resolution != null){
            $convertresolution=array();
            $resolution = explode(",",$settings->transcoding_resolution);
                foreach($resolution as $value){
                    if($value == "240p"){
                        $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
                        array_push($convertresolution,$r_240p);
                    }
                    if($value == "360p"){
                        $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
                        array_push($convertresolution,$r_360p);

                    }
                    if($value == "480p"){
                        $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
                        array_push($convertresolution,$r_480p);

                    }
                    if($value == "720p"){
                        $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
                        array_push($convertresolution,$r_720p);

                    }
                    if($value == "1080p"){
                        $r_1080p  = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);
                        array_push($convertresolution,$r_1080p);
                    }
            }
            
        }
        $StorageSetting = StorageSetting::first();

            if($StorageSetting->site_storage == 1){

                if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {
                            
                    $settings = Setting::first();

                        $trailer = $data['trailer'];
                        $trailer_path  = URL::to('storage/app/season_trailer/');
                        // $trailer_Video =  time().'_'.$trailer->getClientOriginalName();  
                        $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                        $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                        $trailer->move(storage_path('app/season_trailer/'), $trailer_Video);
                        $trailer_video_name = strtok($trailer_Video, '.');
                        $M3u8_save_path = $trailer_path.'/'.$trailer_video_name.'.m3u8';
                        $storepath  = URL::to('storage/app/season_trailer/');
                        $data['trailer'] = $M3u8_save_path;
                        $data['trailer_type']  = 'm3u8_url';
                        $data['landing_mp4_url'] = $trailer_path.'/'.$trailer_video_name.'.mp4';
                                    
                }
                else{

                    $image_path = public_path().'/uploads/season_images/';
                    $path = public_path().'/uploads/season_videos/';

                if($trailer != '') {   
                    //code for remove old file
                    if($trailer != ''  && $trailer != null){
                        $file_old = $path.$trailer;
                        if (file_exists($file_old)){
                        unlink($file_old);
                        }
                    }
                    //upload new file
                    $randval = Str::random(16);
                    $file = $trailer;
                    $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
                    $file->move($path, $trailer_vid);
                    $data['trailer']  = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;
                    $data['trailer_type']  = 'mp4_url';
                    $data['landing_mp4_url']  = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;

                } else {
                    $data['trailer'] = '';
                    $data['trailer_type']  = '';
                    $data['landing_mp4_url']  = '';
                }

            }
            }elseif($StorageSetting->aws_storage == 1){

                if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {


                    $file = $request->file('trailer');
                    $file_folder_name =  $file->getClientOriginalName();
                    // $name = time() . $file->getClientOriginalName();
                    $name_mp4 = $file->getClientOriginalName();
                    $name_mp4 = $name_mp4 == null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        
                    $newfile = explode(".mp4",$name_mp4);
                    $namem3u8 = $newfile[0].'.m3u8';   
                    $name = $namem3u8 == null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        
                    $filePath = $StorageSetting->aws_season_trailer_path.'/'. $name;
                    $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
                    $transcode_path_mp4 = @$StorageSetting->aws_storage_path.'/'. $name_mp4;
                    Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
                    $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                    $M3u8_save_path = $path.$transcode_path;
        
                    $data['trailer'] = $M3u8_save_path;
                    $data["trailer_type"] = 'm3u8_url';
                    $data['landing_mp4_url']  = $path.$transcode_path_mp4;
        
                }else{
                    if($trailer != '') {   
                            //code for remove old file
                            $file = $request->file('trailer');
                            $file_folder_name =  $file->getClientOriginalName();
                            // $name = time() . $file->getClientOriginalName();
                            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                            $filePath = $StorageSetting->aws_season_trailer_path.'/'. $name;
                            Storage::disk('s3')->put($filePath, file_get_contents($file));
                            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                            $trailer = $path.$filePath;
                            $data["trailer"] = $trailer;
                            $data["trailer_type"] = 'video_mp4';
                            $data['landing_mp4_url']  = $path.$filePath;
        
                    }
                }
        

            }else{              

            if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1 && $StorageSetting->aws_storage == 0) {

                $trailer = $data['trailer'];
                $trailer_path  = URL::to('storage/app/season_trailer/');
                // $trailer_Video =  time().'_'.$trailer->getClientOriginalName();  
                $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                $trailer->move(storage_path('app/season_trailer/'), $trailer_Video);
                $trailer_video_name = strtok($trailer_Video, '.');
                $M3u8_save_path = $trailer_path.'/'.$trailer_video_name.'.m3u8';
                $storepath  = URL::to('storage/app/season_trailer/');
                // $ffmpeg = \Streaming\FFMpeg::create();
                // $videos = $ffmpeg->open('public/uploads/season_trailer'.'/'.$trailer_Video);
                
                // $r_144p  = (new Representation)->setKiloBitrate(95)->setResize(256, 144);
                // $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
                // $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
                // $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
                // $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
                // $r_1080p = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);
                
                // $videos->hls()
                //         ->x264()
                //         ->addRepresentations($convertresolution)
                //         ->save('public/uploads/season_trailer'.'/'.$trailer_video_name.'.m3u8');
                
                $data['trailer'] = $M3u8_save_path;
                $data['trailer_type']  = 'm3u8_url';
                $data['landing_mp4_url']  = $trailer_path.'/'.$trailer_video_name.'.mp4';
                                    
            }
            else{

                $image_path = public_path().'/uploads/season_images/';
                $path = public_path().'/uploads/season_videos/';

            if($trailer != '') {   
                //code for remove old file
                if($trailer != ''  && $trailer != null){
                    $file_old = $path.$trailer;
                    if (file_exists($file_old)){
                    unlink($file_old);
                    }
                }
                //upload new file
                $randval = Str::random(16);
                $file = $trailer;
                $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
                $file->move($path, $trailer_vid);
                $data['trailer']  = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;
                $data['trailer_type']  = 'mp4_url';
                $data['landing_mp4_url']  = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;


            } else {
                $data['trailer'] = '';
                $data['trailer_type']  = '';
                $data['landing_mp4_url']  = '';

            }

        }
    }
        $image_path = public_path().'/uploads/season_images/';
        $path = public_path().'/uploads/season_videos/';

        if($image != '') {   
           
            $file = $image;

            if(compress_image_enable() == 1){
    
                $season_filename  = time().'.'.compress_image_format();
                $season_image     =  'season_'.$season_filename ;
                Image::make($file)->save(base_path().'/public/uploads/season_images/'.$season_image,compress_image_resolution() );
            }else{

                $season_filename  = time().'.'.$image->getClientOriginalExtension();
                $season_image     =  'season_'.$season_filename ;
                Image::make($file)->save(base_path().'/public/uploads/season_images/'.$season_image );
            }  

            $data['image'] =  URL::to('/').'/public/uploads/season_images'.'/'.$season_image;

        } else {

            $data['image']  =  URL::to('/').'/public/uploads/images/default.jpg';

        } 

        if(!empty($data['ppv_access'])){
            $access = $data['ppv_access'];
        }else{
            $access = null;
        }
        if(!empty($data['ppv_price'])){
            $ppv_price = $data['ppv_price'];
        }else{
            $ppv_price = null;
        }
        if(!empty($data['ppv_interval'])){
            $ppv_interval = $data['ppv_interval'];
        }else{
            $ppv_interval = 0;
        }
        if(!empty($data['ios_ppv_price'])){
            $ios_ppv_price = $data['ios_ppv_price'];
        }else{
            $ios_ppv_price = null;
        }
        // if(!empty($data['landing_mp4_url'])){
        //     $landing_mp4_url = $data['landing_mp4_url'];
        // }else{
        //     $landing_mp4_url = '';
        // }
        // $data['series_id'] = $data['series_id']; 
        // $data['access'] = $access; 
        // $data['ppv_price'] = $ppv_price; 
        // $data['ppv_interval'] = $ppv_interval; 
        $series = new SeriesSeason;
        $series->series_id = $data['series_id'];
        $series->image = $data['image'];
        $series->trailer = $data['trailer'];
        $series->trailer_type = $data['trailer_type'];
        $series->access = $access;
        $series->ppv_price = $ppv_price;
        $series->ppv_interval = $ppv_interval;
        $series->ios_product_id = $ios_ppv_price;
        $series->landing_mp4_url = $data['landing_mp4_url'];
        $series->series_seasons_name = $data['series_seasons_name'];
        $series->series_seasons_slug =  Str::slug($data['series_seasons_name']) ;
        $series->series_seasons_type = !empty($data['series_seasons_type']) ? $data['series_seasons_type'] : null;
        // $series->ppv_price_240p = $data['ppv_price_240p'];
        // $series->ppv_price_360p = $data['ppv_price_360p'];
        $series->ppv_price_480p = $data['ppv_price_480p'];
        $series->ppv_price_720p = $data['ppv_price_720p'];
        $series->ppv_price_1080p = $data['ppv_price_1080p'];
        // $series->ios_ppv_price_240p = $data['ios_ppv_price_240p'];
        // $series->ios_ppv_price_360p = $data['ios_ppv_price_360p'];
        $series->ios_ppv_price_480p = $data['ios_ppv_price_480p'];
        $series->ios_ppv_price_720p = $data['ios_ppv_price_720p'];
        $series->ios_ppv_price_1080p = $data['ios_ppv_price_1080p'];
        $series->save();
        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1 && $StorageSetting->aws_storage == 0) {
        ConvertSerieTrailer::dispatch($series,$storepath,$convertresolution,$trailer_video_name,$trailer_Video);
        }
        // $series = SeriesSeason::create($data);
        // return Redirect::to('admin/series/edit' . '/' . $id)->with(array('note' => 'Successfully Created Season!', 'note_type' => 'success') );
        return Redirect::back();
    }

    // public function create_season($id)
    // {
    //     $data['series_id'] = $id; 
    //     $series = SeriesSeason::create($data);
    //     return Redirect::to('admin/series/edit' . '/' . $id)->with(array('note' => 'Successfully Created Season!', 'note_type' => 'success') );
    // }
    public function Edit_season($id)
    {
        $season = SeriesSeason::where('id',$id)->first();
        $series = Series::where('id',$season->series_id)->first();
        $access_btn_staus = SiteTheme::pluck('access_change_pass')->first();
        // dd($season);
        $compress_image_settings = CompressImage::first();
        $access_password = "ZUrtSvrah3E7fj2";
        $data =array(
            'season' => $season,
            'InappPurchase' => InappPurchase::all(),
            'series' => $series,
            'compress_image_settings' => $compress_image_settings,
            'theme_settings' => SiteTheme::first(),
            'access_password'  => $access_password,
            'access_btn_staus'  => $access_btn_staus
        );

        return View::make('admin/series/season/edit',$data);
    }
    public function Update_season(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $series_season = SeriesSeason::findOrFail($id);

        $trailer = (isset($data['trailer'])) ? $data['trailer'] : '';
        $image = (isset($data['image'])) ? $data['image'] : '';
        
        $image_path = public_path().'/uploads/season_images/';
        $path = public_path().'/uploads/season_videos/';
        $settings = Setting::first();

        $package = User::where('id',1)->first();
        $pack = $package->package;
        $settings = Setting::first();
        if($settings->transcoding_resolution != null){
                $convertresolution=array();
                $resolution = explode(",",$settings->transcoding_resolution);
                    foreach($resolution as $value){
                        if($value == "240p"){
                            $r_240p  = (new Representation)->setKiloBitrate(150)->setResize(426, 240);
                            array_push($convertresolution,$r_240p);
                        }
                        if($value == "360p"){
                            $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
                            array_push($convertresolution,$r_360p);

                        }
                        if($value == "480p"){
                            $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
                            array_push($convertresolution,$r_480p);

                        }
                        if($value == "720p"){
                            $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(1280, 720);
                            array_push($convertresolution,$r_720p);

                        }
                        if($value == "1080p"){
                            $r_1080p  = (new Representation)->setKiloBitrate(4096)->setResize(1920, 1080);
                            array_push($convertresolution,$r_1080p);
                        }
                }
                
            }
            $StorageSetting = StorageSetting::first();

            if($StorageSetting->site_storage == 1){
                if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {

                    $trailer = $data['trailer'];
                    $trailer_path  = URL::to('storage/app/season_trailer/');
                    // $trailer_Video =  time().'_'.$trailer->getClientOriginalName();  
                    $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
                    $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
                    $trailer->move(storage_path('app/season_trailer/'), $trailer_Video);
                    $trailer_video_name = strtok($trailer_Video, '.');
                    $M3u8_save_path = $trailer_path.'/'.$trailer_video_name.'.m3u8';
                    $storepath  = URL::to('storage/app/season_trailer/');

                    $data['trailer'] = $M3u8_save_path;
                    $data['trailer_type']  = 'm3u8_url';
                    $data['landing_mp4_url'] = $trailer_path.'/'.$trailer_video_name.'.mp4';

                }else{
                    if($trailer != '') {   
                        //code for remove old file
                        if($trailer != ''  && $trailer != null){
                            $file_old = $path.$trailer;
                            if (file_exists($file_old)){
                            unlink($file_old);
                            }
                        }
                        //upload new file
                        $randval = Str::random(16);
                        $file = $trailer;
                        $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
                        $file->move($path, $trailer_vid);
                        $data['trailer']  = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;
                        $data['trailer_type']  = 'mp4_url';
                        $data['landing_mp4_url'] = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;

                } else {
                    $data['trailer'] = $series_season->trailer;
                    $data['trailer_type']  = $series_season->trailer_type;
                    $data['landing_mp4_url'] = $series_season->landing_mp4_url;

            }
        }
    }elseif($StorageSetting->aws_storage == 1){



        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {


            $file = $request->file('trailer');
            $file_folder_name =  $file->getClientOriginalName();
            $name_mp4 = $file->getClientOriginalName();
            $name_mp4 = $name_mp4 == null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        
            $newfile = explode(".mp4",$name_mp4);
            $namem3u8 = $newfile[0].'.m3u8';   
            $name = $namem3u8 == null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        
            $filePath = $StorageSetting->aws_season_trailer_path.'/'. $name;
            $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $name;
            $transcode_path_mp4 = @$StorageSetting->aws_storage_path.'/'. $name_mp4;
            Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $M3u8_save_path = $path.$transcode_path;

            $data['trailer'] = $M3u8_save_path;
            $data["trailer_type"] = 'm3u8_url';
            $data['landing_mp4_url'] = $path.$transcode_path_mp4;

        }else{
            if($trailer != '') {   
                    //code for remove old file
                    $file = $request->file('trailer');
                    $file_folder_name =  $file->getClientOriginalName();
                    // $name = time() . $file->getClientOriginalName();
                    $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                    $filePath = $StorageSetting->aws_season_trailer_path.'/'. $name;
                    Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                    $trailer = $path.$filePath;
                    $data["trailer"] = $trailer;
                    $data["trailer_type"] = 'video_mp4';
                    $data['landing_mp4_url'] = $path.$filePath;

            } else {
                $data['trailer'] = $series_season->trailer;
                $data['trailer_type']  = $series_season->trailer_type;
                $data['landing_mp4_url'] = $series_season->landing_mp4_url;

            }
        }


    }else{

        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {

            $trailer = $data['trailer'];
            $trailer_path  = URL::to('storage/app/season_trailer/');
            // $trailer_Video =  time().'_'.$trailer->getClientOriginalName();  
            $trailer_Videoname =  Str::lower($trailer->getClientOriginalName());
            $trailer_Video = time() . "_" . str_replace(" ","_",$trailer_Videoname);
            $trailer->move(storage_path('app/season_trailer/'), $trailer_Video);
            $trailer_video_name = strtok($trailer_Video, '.');
            $M3u8_save_path = $trailer_path.'/'.$trailer_video_name.'.m3u8';
            $landing_mp4_url_path = $trailer_path.'/'.$trailer_video_name.'.mp4';

            $storepath  = URL::to('storage/app/season_trailer/');

            $data['trailer'] = $M3u8_save_path;
            $data['trailer_type']  = 'm3u8_url';
            $data['landing_mp4_url'] = $landing_mp4_url_path;

        }else{
            if($trailer != '') {   
                    //code for remove old file
                    if($trailer != ''  && $trailer != null){
                        $file_old = $path.$trailer;
                        if (file_exists($file_old)){
                        unlink($file_old);
                        }
                    }
                    //upload new file
                    $randval = Str::random(16);
                    $file = $trailer;
                    $trailer_vid  = $randval.'.'.$request->file('trailer')->extension();
                    $file->move($path, $trailer_vid);
                    $data['trailer']  = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;
                    $data['trailer_type']  = 'mp4_url';
                    $data['landing_mp4_url'] = URL::to('/').'/public/uploads/season_videos/'.$trailer_vid;

            } else {
                $data['trailer'] = $series_season->trailer;
                $data['trailer_type']  = $series_season->trailer_type;
                $data['landing_mp4_url'] = $series_season->landing_mp4_url;
            }
        }

    }
        if($image != '') {   
            
            if($image != ''  && $image != null){   
                $file_old = $image_path.$image;    //code for remove old file
                if (file_exists($file_old)){  
                unlink($file_old);
                }
            }

            $file = $image;

            if(compress_image_enable() == 1){
    
                $season_filename  = time().'.'.compress_image_format();
                $season_image     =  'season_'.$season_filename ;
                Image::make($file)->save(base_path().'/public/uploads/season_images/'.$season_image,compress_image_resolution() );
            }else{

                $season_filename  = time().'.'.$image->getClientOriginalExtension();
                $season_image     =  'season_'.$season_filename ;
                Image::make($file)->save(base_path().'/public/uploads/season_images/'.$season_image );
            }  

            $data['image'] =  URL::to('/').'/public/uploads/season_images'.'/'.$season_image;

        } else {
            $data['image']  = $series_season->image;
        } 

        if(!empty($data['ppv_access'])){
            $access = $data['ppv_access'];
        }else{
            $access = $series_season->ppv_access;
        }
        if(!empty($data['ppv_price'])){
            $ppv_price = $data['ppv_price'];
        }else{
            $ppv_price = $series_season->ppv_price;
        }
        if(!empty($data['ppv_interval']) || !empty($data['ppv_interval'])  && $data['ppv_interval'] == 0){
            $ppv_interval = $data['ppv_interval'];
        }else{
            $ppv_interval = $series_season->ppv_interval;
        }
        if(!empty($data['ios_ppv_price'])){
            $ios_ppv_price = $data['ios_ppv_price'];
        }else{
            $ios_ppv_price = $series_season->ios_ppv_price;
        }
        if(!empty($data['landing_mp4_url'])){
            $landing_mp4_url = $data['landing_mp4_url'];
        }else{
            $landing_mp4_url = $series_season->landing_mp4_url;
        }
        // dd($landing_mp4_url);
        $series_season->series_id = $series_season->series_id;
        $series_season->image = $data['image'];
        $series_season->trailer = $data['trailer'];
        $series_season->trailer_type = $data['trailer_type'];
        $series_season->access = $access;
        if($series_season->access == "ppv"){
            $series_season->ppv_price = $ppv_price;
        } else{
            $series_season->ppv_price = null;
        }
        $series_season->ppv_interval = $ppv_interval;
        $series_season->ios_product_id = $ios_ppv_price;
        $series_season->landing_mp4_url = $data['landing_mp4_url'];
        $series_season->series_seasons_name = $data['series_seasons_name'];
        $series_season->series_seasons_slug =  Str::slug($data['series_seasons_name']) ;
        $series_season->series_seasons_type = !empty($data['series_seasons_type']) ? $data['series_seasons_type'] : null;
        $series_season->ppv_price_480p = $data['ppv_price_480p'];
        $series_season->ppv_price_720p = $data['ppv_price_720p'];
        $series_season->ppv_price_1080p = $data['ppv_price_1080p'];
        $series_season->ios_ppv_price_480p = $data['ios_ppv_price_480p'];
        $series_season->ios_ppv_price_720p = $data['ios_ppv_price_720p'];
        $series_season->ios_ppv_price_1080p = $data['ios_ppv_price_1080p'];
        $series_season->updated_by = Auth::user()->id;
        $series_season->save();
        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1  && $StorageSetting->aws_storage == 0) {
            ConvertSerieTrailer::dispatch($series_season,$storepath,$convertresolution,$trailer_video_name,$trailer_Video);
        }

        return Redirect::back();
    
    }
    
    public function destroy_season($id)
    {
        try {

            $series_id = SeriesSeason::find($id)->series_id;

            $season = SeriesSeason::find($id); 
            $episodes = Episode::where('season_id',$season->id)->pluck('id');
            $SeriesId = $season->series_id;

            // dd(Auth::user()->id);
            DeleteLog::create([
                                'series_id'     =>$series_id,
                                'season_id'     =>$season->id,
                                'user_id'       => Auth::user()->id,
                                'deleted_item'  => 'season',
                                'updated_at'    =>now(),
                                'created_at'    =>now()
                            ]);



            // $episodes = $season->episodes->pluck('id');
            // dd($episodes);
            foreach($episodes as $episode_id ){

                $Episode   = Episode::find($episode_id);

                        //  Delete Existing  Image
                if (File::exists(base_path('public/uploads/images/'.$Episode->image))) {
                    File::delete(base_path('public/uploads/images/'.$Episode->image));
                }

                        //  Delete Existing Player Image
                if (File::exists(base_path('public/uploads/images/'.$Episode->player_image))) {
                    File::delete(base_path('public/uploads/images/'.$Episode->player_image));
                }

                        //  Delete Existing  Tv Image
                if (File::exists(base_path('public/uploads/images/'.$Episode->tv_image))) {
                    File::delete(base_path('public/uploads/images/'.$Episode->tv_image));
                }

                        //  Delete Existing  Episode
                $directory = storage_path('app/public');

                $info = pathinfo($Episode->mp4_url);
            
                $pattern =  $info['filename'] . '*';
            
                $files = glob($directory . '/' . $pattern);
            
                foreach ($files as $file) {
                    if ( File::isFile($file) && File::exists($file)) {
                        unlink($file);
                    } 
                }

                Episode::destroy($episode_id);
            }

                    //  Delete Existing Image - Season
            $season_image = basename($season->image);

            if (File::exists(base_path('public/uploads/season_images/'.$season_image))) {
                File::delete(base_path('public/uploads/season_images/'.$season_image));
            }

                    //  Delete Existing Trailer - Season

            $vseason_trailer = pathinfo($season->trailer)['filename'];

            $directory = base_path('storage/app/season_trailer/');
                    
            $pattern =  $vseason_trailer.'*';

            $files = glob($directory . $pattern);

            foreach ($files as $file) {
                File::delete($file);
            }
          
            SeriesSeason::destroy($id);
             

        } catch (\Throwable $th) {
            // return $th->getMessage();

            return abort (404);
        }

        return Redirect::to('admin/series/edit' . '/' . $SeriesId)->with(array('note' => 'Successfully Deleted Season', 'note_type' => 'success') );
    }

    public function manage_season($series_id,$season_id)
    {
        $series = Series::find($series_id);
        $episodes = Episode::where('series_id' ,'=', $series_id)
        ->where('season_id' ,'=', $season_id)->orderBy('episode_order')->get();
        $compress_image_settings = CompressImage::first();
        $season_name = SeriesSeason::where('id', $season_id)->pluck('series_seasons_name')->first();
        $series_seasons_type = SeriesSeason::where('id', $season_id)->pluck('series_seasons_type')->first();

        // dd($season_name);

        $StorageSetting = StorageSetting::first();
        // dd($StorageSetting);
        if($StorageSetting->site_storage == 1){
            $dropzone_url =  URL::to('admin/episode_upload');
        }elseif($StorageSetting->aws_storage == 1){
            $dropzone_url =  URL::to('admin/AWSEpisodeUpload');
        }else{ 
            $dropzone_url =  URL::to('admin/episode_upload');
        }

        $video_js_Advertisements = Advertisement::where('status',1)->get() ;

            // Bunny Cdn get Videos 
    
            $storage_settings = StorageSetting::first();

            if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 
            && !empty($storage_settings->bunny_cdn_hostname) && !empty($storage_settings->bunny_cdn_storage_zone_name) 
            && !empty($storage_settings->bunny_cdn_ftp_access_key)  ){

                $url = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
                
                $ch = curl_init();
                
                $options = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                        'Content-Type: application/json',
                    ),
                );
                
                curl_setopt_array($ch, $options);
                
                $response = curl_exec($ch);
                
                if (!$response) {
                    die("Error: " . curl_error($ch));
                } else {
                    $decodedResponse = json_decode($response, true);
                
                    if ($decodedResponse === null) {
                        die("Error decoding JSON response: " . json_last_error_msg());
                    }
            
                }
                curl_close($ch);
                // dd($decodedResponse);

                
                $videolibraryurl = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
                
                $ch = curl_init();
                
                $options = array(
                    CURLOPT_URL => $videolibraryurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                        'Content-Type: application/json',
                    ),
                );
                
                curl_setopt_array($ch, $options);
                
                $response = curl_exec($ch);
                $videolibrary = json_decode($response, true);
                curl_close($ch);
                // dd($videolibrary); ApiKey

            }else{
                $decodedResponse = [];
                $videolibrary = [];

            }
        
            // $response->getBody();

            if(!empty($storage_settings) && !empty($storage_settings->bunny_cdn_file_linkend_hostname) ){
                $streamUrl = $storage_settings->bunny_cdn_file_linkend_hostname;
            }else{
                $streamUrl = '';
            }

        $theme_settings = SiteTheme::first();
        if($theme_settings->enable_video_cipher_upload == 1){
            $post_route = URL::to('admin/episode/VideoCipheCreate');
        }else{
            $post_route = URL::to('admin/episode/create');
        }


        if($this->Enable_Flussonic_Upload == 1){
           
            try {
                $client = new \GuzzleHttp\Client();

                $response = $client->request('GET', "{$this->Flussonic_Server_Base_URL}streamer/api/v3/vods/{$this->Flussonic_Storage_Tag}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->Flussonic_Auth_Key, 
                    'Content-Type' => 'application/json', 
                ]
            ]);
        
            $responseData = json_decode($response->getBody(), true);
            $FlussonicUploadlibrary =  $responseData['storages'];
               
            } catch (RequestException $e) {
                $FlussonicUploadlibrary = [];
            }
        }else{
            $FlussonicUploadlibrary = [];
        }
        
        $data = array(
                'headline' => '<i class="fa fa-edit"></i> Manage episodes of Season '.$season_id.' : '.$series->title,
                'episodes' => $episodes,
                'series' => $series,
                'season_id' => $season_id,
                'post_route' => $post_route,
                'button_text' => 'Create Episode',
                'admin_user' => Auth::user(),
                'age_categories' => AgeCategory::all(),
                'settings' => Setting::first(),
                'InappPurchase' => InappPurchase::all(),
                'post_dropzone_url' => $dropzone_url,
                "subtitles" => Subtitle::all(),
                'video_js_Advertisements' => $video_js_Advertisements ,
                "ads_category" => Adscategory::all(),
                'storage_settings' => $storage_settings ,
                'videolibrary' => $videolibrary ,
                'streamUrl' => $streamUrl ,
                'theme_settings' => SiteTheme::first(),
                'compress_image_settings' => $compress_image_settings,
                'theme_settings' => $theme_settings ,
                'season_name'        => $season_name,
                'FlussonicUploadlibrary' => $FlussonicUploadlibrary ,
                'series_seasons_type'        => $series_seasons_type,
            );

        if($theme_settings->enable_video_cipher_upload == 1){
            return View::make('admin.series.EpisodeUploadVideoCipher', $data);
        }else{
            return View::make('admin.series.season_edit', $data);
        }

    }

    public function create_episode(Request $request)
    {
        
        $data = $request->all();
        $settings =Setting::first();

        if(!empty($data['ppv_price'])){
            $ppv_price = $data['ppv_price'];
            $ppv_price = null;
        }elseif(!empty($data['ppv_status']) || $settings->ppv_status == 1){
            $ppv_price = $settings->ppv_price;
            $ppv_price = null;
        }else{
            $ppv_price = null;
        }

        $id = $data['episode_id'];
        $episodes = Episode::findOrFail($id);

        if($episodes->type == 'm3u8'){
            $type = 'm3u8';
        }elseif($episodes->type == 'aws_m3u8'){
            $type = 'aws_m3u8';
        }elseif($episodes->type == 'm3u8_url'){
            $type = 'm3u8_url';
        }  elseif($episodes->type == 'bunny_cdn'){
            $type = 'bunny_cdn';
        } else{
            $type = 'file';
        }

       $mobileimages = public_path('/uploads/mobileimages');
         $Tabletimages = public_path('/uploads/Tabletimages');
         $PCimages = public_path('/uploads/PCimages');

        if (!file_exists($mobileimages)) {
            mkdir($mobileimages, 0755, true);
        }

        if (!file_exists($Tabletimages)) {
            mkdir($Tabletimages, 0755, true);
        }

        if (!file_exists($PCimages)) {
            mkdir($PCimages, 0755, true);
        }

        $path = public_path().'/uploads/episodes/';
        $image_path = public_path().'/uploads/images/';
        
        $image = (isset($data['image'])) ? $data['image'] : '';

        $file = $image;
        if (compress_responsive_image_enable() == 1 || compress_responsive_image_enable() == 0) {
           
        if ($request->hasFile('image') || !empty($data['video_image_url'])) {

            // $image = !empty($request->file('image')) ? $request->file('image') : $data['video_image_url'];

            $image = !empty($request->file('image')) ? $request->file('image') : null;
           
                if ($image) {
                    $image_filename = 'episode_' . time() . '_image.' . $image->getClientOriginalExtension();
                } else {
                    $local_image_path = public_path('/uploads/images/' . basename($data['video_image_url'])); // Adjust this if necessary
                    if (file_exists($local_image_path)) {
                        $image = Image::make($local_image_path);
                        $image_filename = 'episode_' . time() . '_image.webp';
                        // dd($image_filename); 
                    } 
                    
                }
                Image::make($image)->resize(187,332)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                Image::make($image)->resize(244,435)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                Image::make($image)->resize(198,351)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                
                // dd($image_filename);
                $data["responsive_image"] = $image_filename;

        }else{

            $data["responsive_image"] = default_vertical_image(); 
        }

        if ($request->hasFile('player_image') || !empty($data['selected_image_url'])) {

            $player_image = !empty($request->file('player_image')) ? $request->file('player_image') : null;

            if ($player_image) {
                $player_image_filename = 'episode_' .time() . '_player_image.' . $player_image->getClientOriginalExtension();
            } else {
                $local_image_path = public_path('/uploads/images/' . basename($data['selected_image_url'])); // Adjust this if necessary
                if (file_exists($local_image_path)) {
                    $player_image = Image::make($local_image_path);
                    $player_image_filename = 'episode_' . time() . '_player_image.webp';
                    // dd($player_image_filename); 
                } 
                
            }
            

                Image::make($player_image)->resize(332,187)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                Image::make($player_image)->resize(435,244)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                Image::make($player_image)->resize(351,198)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                // dd($player_image_filename);
                $data["responsive_player_image"] = $player_image_filename ;

        }else{

            $data["responsive_player_image"] = default_horizontal_image();
        }


        
        if ($request->hasFile('tv_image')) {

            $tv_image = $request->file('tv_image');

                $tv_image_filename = 'episode_' .time() . '_tv_image.' . $tv_image->getClientOriginalExtension();

                Image::make($tv_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $tv_image_filename, compress_image_resolution());
                Image::make($tv_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $tv_image_filename, compress_image_resolution());
                Image::make($tv_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $tv_image_filename, compress_image_resolution());
                
                $data["responsive_tv_image"] = $tv_image_filename;

        }else{

            $data["responsive_tv_image"] = default_horizontal_image(); 
        }


        }else{

            $data["responsive_image"] = null;
            $data["responsive_player_image"] = null; 
            $data["responsive_tv_image"] = null; 
            
        }

            if(!empty($image)){

                 if($image != ''  && $image != null){

                    $image = !empty($request->file('image')) ? $request->file('image') : null;

                    if ($image) {
                        $file_old = $image_path.$image;

                        if (file_exists($file_old)){
                            unlink($file_old);
                        } 
                    }else {
                        $image_path = public_path('/uploads/images/' . basename($data['video_image_url'])); // Adjust this if necessary
                        if (file_exists($local_image_path)) {
                            $image = Image::make($local_image_path);
                            $image_filename = 'episode_' . time() . '_image.webp';$image_filename = 'episode_' . time() . '_image.webp'; // You can customize this as needed
                            $file_old = $image_path . $image_filename;
                            $image->save($file_old);
                            unlink($file_old);
                        } 
                        
                    }
                        // dd(file_exists($file_old));

                    // $file_old = $image_path.$image;

                    // if (file_exists($file_old)){
                    // unlink($file_old);
                    // }
                }

                if(compress_image_enable() == 1 || compress_image_enable() == 0){
                    $image = !empty($request->file('image')) ? $request->file('image') : null;
                    if ($image ) {
                        $episode_filename  = time().'.'.compress_image_format();
                        $episode_image     =  'episode-'.$episode_filename ;
                        Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_image,compress_image_resolution() );
                    } else {
                        $local_image_path = public_path('/uploads/images/' . basename($data['video_image_url']));
                        if (file_exists($local_image_path)) {
                            $image = Image::make($local_image_path);
                            
                            $episode_filename = time() . '.' . compress_image_format();
                            $episode_image = 'episode-' . $episode_filename;

                            
                            $image->save(base_path() . '/public/uploads/images/' . $episode_image, compress_image_resolution());
                            // dd(base_path() . '/public/uploads/images/' . $episode_image, compress_image_resolution());
                        } else {
                            throw new \Exception('File does not exist at the specified path: ' . $local_image_path);
                        }
                        
                    }

                }else{

                    $episode_filename  = time().'.'.$image->getClientOriginalExtension();
                    $episode_image     =  'episode-'.$episode_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_image );
                }  

            $data['image'] = $episode_image ;

        }else if (!empty($request->video_image_url)) {
            $data["image"] = $request->video_image_url;
        } else {

            $data['image'] = 'placeholder.jpg';
        }
        
        $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

        $player_image = $player_image;

        if($request->hasFile('player_image')){

            if($player_image != ''  && $player_image != null){
                $file_old = $image_path.$player_image;
               if (file_exists($file_old)){
                unlink($file_old);
               }
           }

           if(compress_image_enable() == 1){
                
                $episode_player_filename  = time().'.'.compress_image_format();
                $episode_player_image     =  'episode-player-'.$episode_player_filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_player_image,compress_image_resolution() );
            }else{

                $episode_player_filename  = time().'.'.$image->getClientOriginalExtension();
                $episode_player_image     =  'episode-player-'.$episode_player_filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_player_image );
            }  

           $player_image  = $episode_player_image ;

         }else if (!empty($request->selected_image_url)) {
            $player_image  = $request->selected_image_url;
        } else {
            $player_image = "default_horizontal_image.jpg";
         }

         if($request->hasFile('tv_image')){

            $tv_image = $request->tv_image;

            if(compress_image_enable() == 1){

                $Episode_tv_filename   = 'Episode-TV-Image'.time().'.'. compress_image_format();
                Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Episode_tv_filename , compress_image_resolution() );

            }else{

                $Episode_tv_filename   = 'Episode-TV-Image'.time().'.'.$file->getClientOriginalExtension();
                Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Episode_tv_filename );
            }

            $episodes->tv_image = $Episode_tv_filename;

        }else if (!empty($request->selected_tv_image_url)) {
            $episodes->tv_image  = $request->selected_tv_image_url;
        }

        if(!empty($data['searchtags'])){
            $searchtags = $data['searchtags'];
        }else{
            $searchtags = null;
        }
        if(empty($data['active'])){
            $data['active'] = 0;
        }
        if(empty($data['views'])){
            $data['views'] = 0;
        }

        if(!empty($data['featured'])){
            $data['featured'] = 1;
        }else{
            $data['featured'] = 0;
        }
        if(empty($data['skip_recap'])){
            $data['skip_recap'] = "";
        }
        if(empty($data['skip_intro'])){
            $data['skip_intro'] = "";
        }
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
        $data['ppv_status'] = 1;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

         // free_content

         if(isset($data['free_content_duration'])){
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['free_content_duration']);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['free_content_duration'] = $time_seconds;
        }

        
        // $episode_upload = (isset($data['episode_upload'])) ? $data['episode_upload'] : '';

        // if($episode_upload != '' && $request->hasFile('episode_upload')) {

        //     $ffprobe = \FFMpeg\FFProbe::create();
        //     $disk = 'public';
        //     $data['duration'] = $ffprobe->streams($request->episode_upload)
        //     ->videos()
        //     ->first()                  
        //     ->get('duration'); 

        //     $rand = Str::random(16);
        //     $path = $rand . '.' . $request->episode_upload->getClientOriginalExtension();
        //     $request->episode_upload->storeAs('public', $path);
        //     $data['path'] = $rand;

        //     $thumb_path = 'public';
        //     $this->build_video_thumbnail($request->episode_upload,$path, $rand);

        //     $data['mp4_url'] = URL::to('/').'/storage/app/public/'.$path;
        //     $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
        //     $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
        //     $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
        //     $converted_name = ConvertVideoForStreaming::handle($path);

        //     ConvertVideoForStreaming::dispatch($path);
        // }
            //   $episode = Episode::create($data);
            // dd($data['title']);
            if(!empty($data['title'])){
                // dd($data['global_ppv']);
                $episodes->title = $data['title'];
                }else{
                }  
                if(empty($data['active'])){
                    $active = 0;
                }else{
                    $active =$data['active'];
                }

                if(empty($data['banner'])){
                    $banner = 0;
                }else{
                    $banner = 1;
                }

                if( $request->slug == ''){

                    $slug = Episode::where('slug',$data['title'])->first();

                    $episode_slug = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $data['title'])  :  preg_replace("![^a-z0-9]+!i", "-",  $data['title'].'-'.$id )  ;
                }else{
        
                    $slug = Episode::where('slug',$request->slug)->first();
        
                    $episode_slug = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $data['slug'])  :  preg_replace("![^a-z0-9]+!i", "-",  $data['slug'].'-'.$id )  ;
                }

            $episodes->rating =  $data['rating'];
            $episodes->slug = $episode_slug ;
            $episodes->episode_description =  $data['episode_description'];
            $episodes->type =  $type;
            $episodes->banner =  $banner;
            $episodes->featured =  $data['featured'];

            // $episodes->age_restrict =  $data['age_restrict'];
            $episodes->duration =  $data['duration'];
            // $episodes->access =  $data['access'];
            $episodes->active =  0;
            $episodes->search_tags =  $searchtags;
            $episodes->player_image =  $player_image;
            $episodes->series_id =  $data['series_id'];
            $episodes->season_id =  $data['season_id'];
            $episodes->image =  $data['image'];
            $episodes->skip_recap =  $data['skip_recap'];
            $episodes->recap_start_time =  $data['recap_start_time'];
            $episodes->recap_end_time =  $data['recap_end_time'];
            $episodes->skip_intro =  $data['skip_intro'];
            $episodes->intro_start_time =  $data['intro_start_time'];
            $episodes->intro_end_time =  $data['intro_end_time'];
            $episodes->ppv_price =  $ppv_price;
            $episodes->ppv_status =  $data['ppv_status'];
            $episodes->responsive_image =  $data['responsive_image'];
            $episodes->responsive_player_image =  $data['responsive_player_image'];
            $episodes->responsive_tv_image =  $data['responsive_tv_image'];
            $episodes->status =  $type == 'm3u8' ? 0 : 1;
            
            // {{-- Ads Video.Js Player--}}


            if( admin_ads_pre_post_position() == 1){
                
                $episodes->pre_post_ads =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
                $episodes->post_ads     =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
                $episodes->pre_ads      =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
            }
            else{
                
                $episodes->pre_ads      =  (!empty($data['pre_ads']) ? $data['pre_ads'] : null );
                $episodes->post_ads     =  (!empty($data['post_ads']) ? $data['post_ads'] : null );
                $episodes->pre_post_ads =  null ;
            }

            $episodes->mid_ads  =  (!empty($data['mid_ads']) ? $data['mid_ads'] : null );
            $episodes->video_js_mid_advertisement_sequence_time   =  (!empty($data['video_js_mid_advertisement_sequence_time']) ? $data['video_js_mid_advertisement_sequence_time'] : null );

            $episodes->save();

            $shortcodes = $request["short_code"];
            $languages = $request["sub_language"];
            $subtitles = isset($data["subtitle_upload"])? $data["subtitle_upload"] : "";
            // if (!empty($subtitles != "" && $subtitles != null)) {
            //     foreach ($subtitles as $key => $val) {
            //         if (!empty($subtitles[$key])) {
            //             $destinationPath = "public/uploads/subtitles/";
            //             $filename = $episodes->id . "-" . $shortcodes[$key] . ".srt";
            //             $subtitles[$key]->move($destinationPath, $filename);
            //             $subtitle_data["sub_language"] =
            //                 $languages[
            //                     $key
            //                 ]; /*URL::to('/').$destinationPath.$filename; */
            //             $subtitle_data["shortcode"] = $shortcodes[$key];
            //             $subtitle_data["episode_id"] = $id;
            //             $subtitle_data["url"] =
            //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
            //             $episode_subtitle = new SeriesSubtitle();
            //             $episode_subtitle->episode_id = $episodes->id;
            //             $episode_subtitle->shortcode = $shortcodes[$key];
            //             $episode_subtitle->sub_language = $languages[$key];
            //             $episode_subtitle->url =
            //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
            //             $episode_subtitle->save();
            //         }
            //     }
            // }

            // if (!empty($subtitles != "" && $subtitles != null)) {
            //     foreach ($subtitles as $key => $val) {
            //         if (!empty($subtitles[$key])) {
            //             $destinationPath = "public/uploads/subtitles/";
            //             $filename = $episodes->id . "-episode-" . $shortcodes[$key] . ".srt";
                        
            //             // Move uploaded file to destination path
            //             move_uploaded_file($val->getPathname(), $destinationPath . $filename);
                        
            //             // Read contents of the uploaded file
            //             $contents = file_get_contents($destinationPath . $filename);
                        
            //             // Convert time format and add line numbers
            //             $lineNumber = 0;
            //             $convertedContents = preg_replace_callback(
            //                 '/(\d{2}):(\d{2}):(\d{2})[,.](\d{3}) --> (\d{2}):(\d{2}):(\d{2})[,.](\d{3})/',
            //                 function ($matches) use (&$lineNumber) {
            //                     $lineNumber++;
            //                     return "{$lineNumber}\n{$matches[1]}:{$matches[2]}:{$matches[3]},{$matches[4]} --> {$matches[5]}:{$matches[6]}:{$matches[7]},{$matches[8]}";
            //                 },
            //                 $contents
            //             );
                        
            //             // Store converted contents to a new file
            //             $newDestinationPath = "public/uploads/convertedsubtitles/";
            //             if (!file_exists($newDestinationPath)) {
            //                 mkdir($newDestinationPath, 0755, true);
            //             }
            //             file_put_contents($newDestinationPath . $filename, $convertedContents);
                        
            //             // Save subtitle data to database
            //             $subtitle_data = [
            //                 "episode_id" => $episodes->id,
            //                 "shortcode" => $shortcodes[$key],
            //                 "sub_language" => $languages[$key],
            //                 "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
            //                 "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
            //         ];
            //             $episode_subtitle = SeriesSubtitle::create($subtitle_data);
            //         }
            //     }
            // }

                        // Define the convertTimeFormat function globally
                        function convertTimeFormat($hours, $minutes, $milliseconds) {
                            $totalSeconds = $hours * 3600 + $minutes * 60 + $milliseconds / 1000;
                            $formattedTime = gmdate("H:i:s", $totalSeconds);
                            $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                            return "{$formattedTime},{$formattedMilliseconds}";
                        }
            
                        if (!empty($subtitles != "" && $subtitles != null)) {
                            foreach ($subtitles as $key => $val) {
                                if (!empty($subtitles[$key])) {
                                    $destinationPath = "public/uploads/subtitles/";
            
                                    if (!file_exists($destinationPath)) {
                                        mkdir($destinationPath, 0755, true);
                                    }
            
                                    $filename = $episodes->id . "-episode-" . $shortcodes[$key] . ".srt";
            
                                    SeriesSubtitle::where('episode_id', $episodes->id)->where('shortcode', $shortcodes[$key])->delete();
            
                                    // Move uploaded file to destination path
                                    move_uploaded_file($val->getPathname(), $destinationPath . $filename);
            
                                    // Read contents of the uploaded file
                                    $contents = file_get_contents($destinationPath . $filename);
            
                                    // Convert time format and add line numbers
                                    $lineNumber = 0;
                                    $convertedContents = preg_replace_callback(
                                        '/(\d{2}):(\d{2})\.(\d{3}) --> (\d{2}):(\d{2})\.(\d{3})/',
                                        function ($matches) use (&$lineNumber) {
                                            // Increment line number for each match
                                            $lineNumber++;
                                            // Convert time format and return with the line number
                                            return "{$lineNumber}\n" . convertTimeFormat($matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat($matches[4], $matches[5], $matches[6]);
                                        },
                                        $contents
                                    );
            
                                    // Store converted contents to a new file
                                    $newDestinationPath = "public/uploads/convertedsubtitles/";
                                    if (!file_exists($newDestinationPath)) {
                                        mkdir($newDestinationPath, 0755, true);
                                    }
                                    file_put_contents($newDestinationPath . $filename, $convertedContents);
            
                                    // Save subtitle data to database
                                    $subtitle_data = [
                                        "episode_id" => $episodes->id,
                                        "shortcode" => $shortcodes[$key],
                                        "sub_language" => $languages[$key],
                                        "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
                                        "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
                                    ];
                                    $episode_subtitle = SeriesSubtitle::create($subtitle_data);
                                }
                            }
                        }

        return Redirect::to('admin/season/edit/'.$data['series_id'].'/'.$data['season_id'])->with(array('note' => 'New Episode Successfully Added!', 'note_type' => 'success') );
    }

    public function destroy_episode($id)
    {
        try {
       
            $series_id = Episode::find($id)->series_id;
            $season_id = Episode::find($id)->season_id;
            $Episode   = Episode::find($id);

            // dd(Auth::user()->id);

            DeleteLog::create([
                'episode_id'      => $Episode->id,
                'series_id'       => $series_id,
                'season_id'       => $season_id,
                'user_id'         => Auth::user()->id,
                'deleted_item'    => 'episode',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

                    //  Delete Existing  Image
            if (File::exists(base_path('public/uploads/images/'.$Episode->image))) {
                File::delete(base_path('public/uploads/images/'.$Episode->image));
            }

                    //  Delete Existing Player Image
            if (File::exists(base_path('public/uploads/images/'.$Episode->player_image))) {
                File::delete(base_path('public/uploads/images/'.$Episode->player_image));
            }

                    //  Delete Existing  Tv Image
            if (File::exists(base_path('public/uploads/images/'.$Episode->tv_image))) {
                File::delete(base_path('public/uploads/images/'.$Episode->tv_image));
            }

                    //  Delete Existing  Episode
            $directory = storage_path('app/public');

            $info = pathinfo($Episode->mp4_url);
        
            $pattern =  $info['filename'] . '*';
        
            $files = glob($directory . '/' . $pattern);
            $destinationPath = storage_path('app/public/frames');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($files as $file) {
                if ( File::isFile($file) && File::exists($file)) {
                    unlink($file);
                } 
            }

            Episode::destroy($id);

            return Redirect::to('admin/season/edit' . '/' . $series_id.'/'.$season_id)->with(array('note' => 'Successfully Deleted Season', 'note_type' => 'success') );
        
        } catch (\Throwable $th) {

            // return $th->getMessage();
            return abort(404);
        }
    }

    public function edit_episode($id)
    {
        $episodes = Episode::find($id);
        $subtitlescount = Subtitle::join('series_subtitles', 'series_subtitles.sub_language', '=', 'subtitles.language')
        ->where(['episode_id' => $id])
        ->count();
        if ($subtitlescount > 0) {
            $subtitles = Subtitle::join('series_subtitles', 'series_subtitles.sub_language', '=', 'subtitles.language')
                ->where(['episode_id' => $id])
                ->get(["subtitles.*", "series_subtitles.url", "series_subtitles.id as series_subtitles_id"]);
        } else {
            $subtitles = Subtitle::all();
        }

        $SeriesSubtitle = SeriesSubtitle::where('episode_id', $id)->get();

        $video_js_Advertisements = Advertisement::where('status',1)->get() ;

        $compress_image_settings = CompressImage::first();

        $theme_settings = SiteTheme::first();

        $subtitles_name = SeriesSubtitle::select('subtitles.language as language')
        ->Join('subtitles', 'series_subtitles.shortcode', '=', 'subtitles.short_code')
        ->where('series_subtitles.episode_id', $id)
        ->get();

        if (count($subtitles_name) > 0) {
        foreach ($subtitles_name as $value) {
        $subtitlesname[] = $value->language;
        }
        $subtitles = implode(', ', $subtitlesname);
        } else {
        $subtitles = 'No Subtitles Added';
        }
       
        $subtitle = SeriesSubtitle::where('episode_id', '=', $id)->get();

        $series_seasons_type = isset($episodes) && !empty($episodes->season_id) ? SeriesSeason::where('id', $episodes->season_id)->pluck('series_seasons_type')->first() : null;

        $post_route =  URL::to('admin/episode/update');

        $data = array(
                'headline' => '<i class="fa fa-edit"></i> Edit Episode '.$episodes->title,
                'episodes' => $episodes,
                'post_route' => URL::to('admin/episode/update'),
                'button_text' => 'Update Episode',
                'admin_user' => Auth::user(),
                'age_categories' => AgeCategory::all(),
                'settings' => Setting::first(),
                "subtitles" => Subtitle::all(),
                // "subtitles" => $subtitles,
                "SeriesSubtitle" => $SeriesSubtitle ,
                "subtitlescount" => $subtitlescount,
                "ads_category" => Adscategory::all(),
                "video_js_Advertisements" => $video_js_Advertisements ,
                'compress_image_settings' => $compress_image_settings,
                'theme_settings' => $theme_settings,
                'page'  => 'Edit',
                'playerui_settings'  => Playerui::first(),
                'playerui'  => Playerui::first(),
                'series_seasons_type' => $series_seasons_type,
            );

        if($theme_settings->enable_video_cipher_upload == 1){
            return View::make('admin.series.EpisodeEditVideoCipher', $data);
        }else{
            return View::make('admin.series.edit_episode', $data);
        }
    }

    public function subtitledestroy($id)
    {
        SeriesSubtitle::destroy($id);

        return Redirect::back()->with([
            "message" => "Successfully Updated Video!",
            "note_type" => "success",
        ]);

    }

    public function update_episode(Request $request)
    {

         $mobileimages = public_path('/uploads/mobileimages');
         $Tabletimages = public_path('/uploads/Tabletimages');
         $PCimages = public_path('/uploads/PCimages');

        if (!file_exists($mobileimages)) {
            mkdir($mobileimages, 0755, true);
        }

        if (!file_exists($Tabletimages)) {
            mkdir($Tabletimages, 0755, true);
        }

        if (!file_exists($PCimages)) {
            mkdir($PCimages, 0755, true);
        }

        $input = $request->all();
        $id = $input['id'];
        $episode  = Episode::findOrFail($id);
        $settings = Setting::first();
        $subtitles = isset($input["subtitle_upload"])? $input["subtitle_upload"] : "";
        
        $searchtags = !empty($input['searchtags']) ? $input['searchtags'] :  $episode->searchtags ;

        if(empty($input['image']) && !empty($episode->image)){
            $image = $episode->image ;
        }else{
            $image = (isset($input['image'])) ? $input['image'] : '';
        }
        
        if(empty($input['player_image']) && !empty($episode->player_image)){
            $player_image = $episode->player_image ;

        }else{
            $player_image = (isset($input['player_image'])) ? $input['player_image'] : '';
        }

        if(!empty($input['ppv_price'])){
            $ppv_price = $input['ppv_price'];
            $ppv_price = null;
        }elseif(!empty($input['ppv_price']) || $settings->ppv_status == 1){
            $ppv_price = $settings->ppv_price;
            $ppv_price = null;
        }else{
            $ppv_price = null;
        }

        $data = $request->all();

        $path = public_path().'/uploads/episodes/';
        $image_path = public_path().'/uploads/images/';
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
        $data['ppv_status'] = 1;
        }
        
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        // free_content

        if(isset($data['free_content_duration'])){
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['free_content_duration']);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['free_content_duration'] = $time_seconds;
        }
        
             if($request->hasFile('image')){

                if($image != ''  && $image != null){
                    $file_old = $image_path.$image;

                        if (file_exists($file_old)){
                        unlink($file_old);
                        }
                }

                $file = $image;

                if(compress_image_enable() == 1){
        
                    $episode_filename  = time().'.'.compress_image_format();
                    $episode_image     =  'episode-'.$episode_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_image,compress_image_resolution() );
                }else{

                    $episode_filename  = time().'.'.$image->getClientOriginalExtension();
                    $episode_image     =  'episode-'.$episode_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_image );
                }  

                $data['image'] = $episode_image ;

            }else if (!empty($request->video_image_url)) {
                $data["image"] = $request->video_image_url;
            } else {
                $data['image'] = $episode->image ;
            }

            if (compress_responsive_image_enable() == 1 || compress_responsive_image_enable() == 0) {
                
                if ($request->hasFile('image') || !empty($data["video_image_url"])) {

                    $image = !empty($request->file('image')) ? $request->file('image') : null;
            
                    if ($image) {
                        $image_filename = 'episode_' . time() . '_image.' . $image->getClientOriginalExtension();
                    } else {
                        $local_image_path = public_path('/uploads/images/' . basename($data['video_image_url'])); // Adjust this if necessary
                        if (file_exists($local_image_path)) {
                            $image = Image::make($local_image_path);
                            $image_filename = 'episode_' . time() . '_image.webp';
                            // dd($image_filename); 
                        } 
                        
                    }
                    Image::make($image)->resize(187,332)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(244,435)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                    Image::make($image)->resize(198,351)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                    
                    // dd($image_filename);
                    $responsive_image = $image_filename;


                        // $image = !empty($request->file('image')) ? $request->file('image') : $data["image"];
                        // $image_filename = !empty($request->file('image')) ? 'episode_' .time() . '_image.' . $image->getClientOriginalExtension() : 'episode_' .time() . '_image.webp';
                        
                        // $image_filename = $image_filename;
                    
                        // Image::make($image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                        // Image::make($image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                        // Image::make($image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                        
                        // $responsive_image = $image_filename;
                    
                }else if (!empty($request->responsive_image)) {
                    $responsive_image  = $request->responsive_image;
                } else{
                    $responsive_image = $episode->responsive_image; 
                }
                if ($request->hasFile('player_image') || !empty($data["selected_image_url"])) {
                    // dd($data);
                    $player_image = !empty($request->file('player_image')) ? $request->file('player_image') : null;
            
                    if ($player_image) {
                        $player_image_filename = 'episode_' .time() . '_player_image.' . $player_image->getClientOriginalExtension();
                    } else {
                        $local_image_path = public_path('/uploads/images/' . basename($data['selected_image_url'])); // Adjust this if necessary
                        if (file_exists($local_image_path)) {
                            $player_image = Image::make($local_image_path);
                            $player_image_filename = 'episode_' . time() . '_player_image.webp';
                            // dd($image_filename); 
                        } 
                        
                    }
                        Image::make($player_image)->resize(332,187)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                        Image::make($player_image)->resize(435,244)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                        Image::make($player_image)->resize(351,198)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                        
                        $responsive_player_image = $player_image_filename;
                    
                }else if (!empty($request->responsive_player_image)) {
                    $responsive_player_image  = $request->responsive_player_image;
                }else{
                
                    $responsive_player_image = $episode->responsive_player_image; 
                }
                
                
                
            if ($request->hasFile('tv_image')) {
                
                $tv_image = $request->file('tv_image');
                
                    $tv_image_filename = 'episode_' .time() . '_tv_image.' . $tv_image->getClientOriginalExtension();
                
                    Image::make($tv_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $tv_image_filename, compress_image_resolution());
                    Image::make($tv_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $tv_image_filename, compress_image_resolution());
                    Image::make($tv_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $tv_image_filename, compress_image_resolution());
                    
                    $responsive_tv_image = $tv_image_filename;
                
                }else if (!empty($request->responsive_tv_image)) {
                    $responsive_tv_image  = $request->responsive_tv_image;
                }else{
                
                    $responsive_tv_image = $episode->responsive_tv_image; 
                }    

            }else{
                    $responsive_image = $episode->responsive_image; 
                    $responsive_player_image = $episode->responsive_player_image; 
                    $responsive_tv_image = $episode->responsive_tv_image; 

            }

            if($request->hasFile('player_image')){

                if($player_image != ''  && $player_image != null){
                    $file_old = $image_path.$player_image;
                   if (file_exists($file_old)){
                    unlink($file_old);
                   }
               }

               $player_image = $player_image;

                if(compress_image_enable() == 1){
            
                    $episode_player_filename  = time().'.'.compress_image_format();
                    $episode_player_image     =  'episode-player-'.$episode_player_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$episode_player_image,compress_image_resolution() );
                }else{

                    $episode_player_filename  = time().'.'.$player_image->getClientOriginalExtension();
                    $episode_player_image     =  'episode-player-'.$episode_player_filename ;
                    Image::make($player_image)->save(base_path().'/public/uploads/images/'.$episode_player_image );
                }  

               $player_image  = $episode_player_image;

             }else if (!empty($request->selected_image_url)) {
                $player_image  = $request->selected_image_url;
            } else if(!empty($episode->player_image)) {
                $player_image = $episode->player_image;
             }else{
                $player_image = "default_horizontal_image.jpg";
            }

             if($request->hasFile('tv_image')){

                if (File::exists(base_path('public/uploads/images/'.$episode->tv_image))) {
                    File::delete(base_path('public/uploads/images/'.$episode->tv_image));
                }

                $tv_image = $request->tv_image;
    
                if(compress_image_enable() == 1){
    
                    $Episode_tv_filename   = 'Episode-TV-Image'.time().'.'. compress_image_format();
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Episode_tv_filename , compress_image_resolution() );
    
                }else{
    
                    $Episode_tv_filename   = 'Episode-TV-Image'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Episode_tv_filename );
                }

                $episode->tv_image = $Episode_tv_filename;
            }else if (!empty($request->selected_tv_image_url)) {
                $episode->tv_image  = $request->selected_tv_image_url;
            }
        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(  $data['slug']  == '' ){

            $slug = Episode::whereNotIn('id',[$id])->where('slug',$request->title)->first();

            $data['slug']  = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $request->title )  : preg_replace("![^a-z0-9]+!i", "-",  $request->title.'-'.$id ) ;
        }else{

            $slug = Episode::whereNotIn('id',[$id])->where('slug',$request->slug)->first();

            $data['slug']  = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $request->title )  : preg_replace("![^a-z0-9]+!i", "-",  $request->title ) ;
        }
        // dd($data['slug']);
        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        if(empty($data['banner'])){
            $banner = 0;
        }else{
            $banner = 1;
        }
        if($episode->type == 'm3u8'){
            $type = 'm3u8';
        }else if($episode->type == 'bunny_cdn'){
            $type = 'bunny_cdn';
        }else{
            $type = $data['type'];
        }

          $episode_upload = (isset($data['episode_upload'])) ? $data['episode_upload'] : '';

        if($episode_upload != '' && $request->hasFile('episode_upload')) {

            $ffprobe = \FFMpeg\FFProbe::create();
            $disk = 'public';
            $data['duration'] = $ffprobe->streams($request->episode_upload)->videos() ->first()->get('duration'); 

            $rand = Str::random(16);
            $path = $rand . '.' . $request->episode_upload->getClientOriginalExtension();
            $request->episode_upload->storeAs('public', $path);
            $data['path'] = $rand;

            $thumb_path = 'public';
            $this->build_video_thumbnail($request->episode_upload,$path, $rand);

            $data['mp4_url'] = URL::to('/').'/storage/app/public/'.$path;
            $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
            $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
            $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
            $converted_name = ConvertVideoForStreaming::handle($path);

            ConvertVideoForStreaming::dispatch($path);
        }
        
        $episode->update($data);
        $episode->skip_recap =  $data['skip_recap'];
        $episode->banner =  $banner;
        $episode->type =  $type;
        $episode->slug =  $slug;
        $episode->search_tags =  $searchtags;
        $episode->recap_start_time =  $data['recap_start_time'];
        $episode->season_id =  $data['season_id'];
        $episode->recap_end_time =  $data['recap_end_time'];
        $episode->skip_intro =  $data['skip_intro'];
        $episode->intro_start_time =  $data['intro_start_time'];
        $episode->intro_end_time =  $data['intro_end_time'];
        $episode->ppv_price =  $ppv_price;
        $episode->player_image =  $player_image;
        $episode->ppv_status =  $data['ppv_status'];
        $episode->slug =  $data['slug'];
        $episode->episode_description =  $data['episode_description'];
        $episode->responsive_image =  $responsive_image;
        $episode->responsive_player_image =  $responsive_player_image;
        $episode->responsive_tv_image =  $responsive_tv_image;
        $episode->episode_id_480p = ( !empty($data["episode_id_480p"])) ? $data["episode_id_480p"] : null;
        $episode->episode_id_720p = (!empty($data["episode_id_720p"])) ? $data["episode_id_720p"] : null;
        $episode->episode_id_1080p =( !empty($data["episode_id_1080p"])) ? $data["episode_id_1080p"] : null;
        $episode->url = !empty($episode->url) ? $episode->url : (!empty($data['m3u8_url']) ? $data['m3u8_url'] : null);
        $episode->mp4_url = !empty($episode->mp4_url) ? $episode->mp4_url : (!empty($data['mp4_url']) ? $data['mp4_url'] : null);
        $episode->embed_video_url = !empty($episode->embed_video_url) ? $episode->embed_video_url : (!empty($data['embed_video_url']) ? $data['embed_video_url'] : null);
        $episode->status =  1;
        $episode->active =  empty($data['active']) ? 0 : 1;
        // dd($episode->active);
        // {{--Ads Video.Js Player--}}


        if( admin_ads_pre_post_position() == 1){

            $episode->pre_post_ads =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
            $episode->post_ads     =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
            $episode->pre_ads      =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
        }
        else{
            
            $episode->pre_ads      =  (!empty($data['pre_ads']) ? $data['pre_ads'] : null );
            $episode->post_ads     =  (!empty($data['post_ads']) ? $data['post_ads'] : null );
            $episode->pre_post_ads =  null ;
        }
        
        $episode->mid_ads  =  (!empty($data['mid_ads']) ? $data['mid_ads'] : null );
        $episode->video_js_mid_advertisement_sequence_time   =  (!empty($data['video_js_mid_advertisement_sequence_time']) ? $data['video_js_mid_advertisement_sequence_time'] : null );


        $episode->save();

        $shortcodes = $request["short_code"];
        $languages = $request["sub_language"];
        // if (!empty($subtitles != "" && $subtitles != null)) {
        //     foreach ($subtitles as $key => $val) {
        //         if (!empty($subtitles[$key])) {
        //             $destinationPath = "public/uploads/subtitles/";
        //             $filename = $episode->id . "-" . $shortcodes[$key] . ".srt";
        //             $subtitles[$key]->move($destinationPath, $filename);
        //             $subtitle_data["sub_language"] =
        //                 $languages[
        //                     $key
        //                 ]; /*URL::to('/').$destinationPath.$filename; */
        //             $subtitle_data["shortcode"] = $shortcodes[$key];
        //             $subtitle_data["episode_id"] = $id;
        //             $subtitle_data["url"] =
        //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
        //             $episode_subtitle = new SeriesSubtitle();
        //             $episode_subtitle->episode_id = $episode->id;
        //             $episode_subtitle->shortcode = $shortcodes[$key];
        //             $episode_subtitle->sub_language = $languages[$key];
        //             $episode_subtitle->url =
        //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
        //             $episode_subtitle->save();
        //         }
        //     }
        // }
        // if (!empty($subtitles != "" && $subtitles != null)) {
        //     foreach ($subtitles as $key => $val) {
        //         if (!empty($subtitles[$key])) {

        //             SeriesSubtitle::where('episode_id',$episode->id)->where('shortcode',$shortcodes[$key])->delete();

        //             $destinationPath = "public/uploads/subtitles/";
        //             $filename = $episode->id . "-episode-" . $shortcodes[$key] . ".srt";
                    
        //             // Move uploaded file to destination path
        //             move_uploaded_file($val->getPathname(), $destinationPath . $filename);
                    
        //             // Read contents of the uploaded file
        //             $contents = file_get_contents($destinationPath . $filename);
                    
        //             // Convert time format and add line numbers
        //             $lineNumber = 0;
        //             $convertedContents = preg_replace_callback(
        //                 '/(\d{2}):(\d{2}):(\d{2})[,.](\d{3}) --> (\d{2}):(\d{2}):(\d{2})[,.](\d{3})/',
        //                 function ($matches) use (&$lineNumber) {
        //                     $lineNumber++;
        //                     return "{$lineNumber}\n{$matches[1]}:{$matches[2]}:{$matches[3]},{$matches[4]} --> {$matches[5]}:{$matches[6]}:{$matches[7]},{$matches[8]}";
        //                 },
        //                 $contents
        //             );
                    
        //             // Store converted contents to a new file
        //             $newDestinationPath = "public/uploads/convertedsubtitles/";
        //             if (!file_exists($newDestinationPath)) {
        //                 mkdir($newDestinationPath, 0755, true);
        //             }
        //             file_put_contents($newDestinationPath . $filename, $convertedContents);
                    
        //             // Save subtitle data to database
        //             $subtitle_data = [
        //                 "episode_id" => $episode->id,
        //                 "shortcode" => $shortcodes[$key],
        //                 "sub_language" => $languages[$key],
        //                 "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
        //                 "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
        //             ];
        //             $episode_subtitle = SeriesSubtitle::create($subtitle_data);
        //         }
        //     }
        // }


                                // Define the convertTimeFormat function globally
                                function convertTimeFormat($hours, $minutes, $milliseconds) {
                                    $totalSeconds = $hours * 3600 + $minutes * 60 + $milliseconds / 1000;
                                    $formattedTime = gmdate("H:i:s", $totalSeconds);
                                    $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                                    return "{$formattedTime},{$formattedMilliseconds}";
                                }
                    
                                if (!empty($subtitles != "" && $subtitles != null)) {
                                    foreach ($subtitles as $key => $val) {
                                        if (!empty($subtitles[$key])) {
                                            $destinationPath = "public/uploads/subtitles/";
                    
                                            if (!file_exists($destinationPath)) {
                                                mkdir($destinationPath, 0755, true);
                                            }
                    
                                            $filename = $episode->id . "-episode-" . $shortcodes[$key] . ".srt";
                    
                                            SeriesSubtitle::where('episode_id', $episode->id)->where('shortcode', $shortcodes[$key])->delete();
                    
                                            // Move uploaded file to destination path
                                            move_uploaded_file($val->getPathname(), $destinationPath . $filename);
                    
                                            // Read contents of the uploaded file
                                            $contents = file_get_contents($destinationPath . $filename);
                    
                                            // Convert time format and add line numbers
                                            $lineNumber = 0;
                                            $convertedContents = preg_replace_callback(
                                                '/(\d{2}):(\d{2})\.(\d{3}) --> (\d{2}):(\d{2})\.(\d{3})/',
                                                function ($matches) use (&$lineNumber) {
                                                    // Increment line number for each match
                                                    $lineNumber++;
                                                    // Convert time format and return with the line number
                                                    return "{$lineNumber}\n" . convertTimeFormat($matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat($matches[4], $matches[5], $matches[6]);
                                                },
                                                $contents
                                            );
                    
                                            // Store converted contents to a new file
                                            $newDestinationPath = "public/uploads/convertedsubtitles/";
                                            if (!file_exists($newDestinationPath)) {
                                                mkdir($newDestinationPath, 0755, true);
                                            }
                                            file_put_contents($newDestinationPath . $filename, $convertedContents);
                    
                                            // Save subtitle data to database
                                            $subtitle_data = [
                                                "episode_id" => $episode->id,
                                                "shortcode" => $shortcodes[$key],
                                                "sub_language" => $languages[$key],
                                                "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
                                                "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
                                            ];
                                            $episode_subtitle = SeriesSubtitle::create($subtitle_data);                                        
                                        }
                                    }
                                }

        $episode = Episode::findOrFail($id);
        return Redirect::to('admin/season/edit' . '/' . $episode->series_id .'/'.$episode->season_id)->with(array('note' => 'Successfully Updated Episode!', 'note_type' => 'success') );
    
    }

    public function EpisodeUpload(Request $request)
    {
        $value = array();
        $data = $request->all();
        $series_id = $data['series_id'] ?? null;
        $season_id = $data['season_id'] ?? null;

        // dd($data);

        $validator = Validator::make($request->all(), [
           'file' => 'required|mimes:video/mp4,video/x-m4v,video/*'
        ]);

        $mp4_url = $data['file'];
        // echo"<pre>";print_r($mp4_url);exit;

        $libraryid = $data['UploadlibraryID'];
        $FlussonicUploadlibraryID = $data['FlussonicUploadlibraryID'];

        $storage_settings = StorageSetting::first();
        $enable_bunny_cdn = SiteTheme::pluck('enable_bunny_cdn')->first();
        if($enable_bunny_cdn == 1){
            if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 && !empty($libraryid) && !empty($mp4_url)){
                return $this->UploadEpisodeBunnyCDNStream( $storage_settings,$libraryid,$data,$season_id);
            }elseif(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 && empty($libraryid)){
                $value["error"] = 3;
                return $value ;
            }
        }elseif($storage_settings->flussonic_storage == 1){
            if(!empty($storage_settings) && $storage_settings->flussonic_storage == 1 && !is_null($FlussonicUploadlibraryID) && !empty($mp4_url)){
                return $this->UploadEpisodeFlussonicStorage(  $storage_settings,$FlussonicUploadlibraryID,$mp4_url,$season_id,$data);
            }elseif(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 && empty($libraryid)){
                $value["error"] = 3;
                return $value ;
            }
        }        

        $file = (isset($data['file'])) ? $data['file'] : '';

        $package = User::where('id',1)->first();
        $pack = $package->package;
        $mp4_url = $data['file'];
        $settings = Setting::first();

        if($pack != "Business" || $pack == "Business" && $settings->transcoding_access  == 0){

            if($file != '') {        

                $rand = Str::random(16);
                $path = $rand . '.' . $file->getClientOriginalExtension();
                $request->file->storeAs('public', $path);
                $storepath  = URL::to('/storage/app/public/'.$path);
                $file = $request->file->getClientOriginalName();

                //  Episode duration 
                $getID3 = new getID3;
                $Video_storepath  = storage_path('app/public/'.$path);       
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];

                $newfile = explode(".mp4",$file);
                $file_folder_name = $newfile[0];       
                $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
                $episode = new Episode();
                $episode->title = $file_folder_name;
                $episode->mp4_url = $storepath;
                $episode->series_id = $series_id;
                $episode->season_id = $season_id;
                $episode->image = 'default_image.jpg';
                $episode->type = 'upload';
                $episode->status = 0;
                $episode->duration = $Video_duration;
                $episode->episode_order = Episode::where('season_id',$season_id)->max('episode_order') + 1 ;
                $episode->save(); 

                $episode_id = $episode->id;
                // dd( $episode->title);
                
                // $outputFolder = storage_path('app/public/frames');

                // if (!is_dir($outputFolder)) {
                //     mkdir($outputFolder, 0755, true);
                // }

                if(Enable_Extract_Image() == 1){
                    // extractImageFromVideo

                    $ffmpeg = \FFMpeg\FFMpeg::create();
                    $videoFrame = $ffmpeg->open($Video_storepath);
                
                    // Define the dimensions for the frame (16:9 aspect ratio)
                    $frameWidth = 1280;
                    $frameHeight = 720;
                
                    // Define the dimensions for the frame (9:16 aspect ratio)
                    $frameWidthPortrait = 1080;  // Set the desired width of the frame
                    $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
                    $randportrait = 'portrait_' . $rand;
                
                    $interval = 5; // Interval for extracting frames in seconds
                    $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                    $totalDuration = intval($totalDuration);

                
                    if ( 600 < $totalDuration) { 
                        $timecodes = [5, 120, 240, 360, 480]; 
                    } else { 
                        $timecodes = [5, 10, 15, 20, 25]; 
                    }

                
                    foreach ($timecodes as $index => $time) {
                        $imagePortraitPath = public_path("uploads/images/{$episode_id}_{$randportrait}_{$index}.jpg");
                        $imagePath = public_path("uploads/images/{$episode_id}_{$rand}_{$index}.jpg");
                
                        try {
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($time))
                                ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
                
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($time))
                                ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
                
                            // Convert JPG to WEBP
                            $webpImagePath = str_replace('.jpg', '.webp', $imagePath);
                            $webpPortraitImagePath = str_replace('.jpg', '.webp', $imagePortraitPath);
                
                            if (file_exists($imagePath)) {
                                $image = imagecreatefromjpeg($imagePath);
                                imagewebp($image, $webpImagePath, 80);
                                imagedestroy($image);
                                unlink($imagePath);
                            }
                
                            if (file_exists($imagePortraitPath)) {
                                $imagePortrait = imagecreatefromjpeg($imagePortraitPath);
                                imagewebp($imagePortrait, $webpPortraitImagePath, 80);
                                imagedestroy($imagePortrait);
                                unlink($imagePortraitPath);
                            }
                
                            $VideoExtractedImage = new VideoExtractedImages();
                            $VideoExtractedImage->user_id = Auth::user()->id;
                            $VideoExtractedImage->socure_type = 'Episode';
                            $VideoExtractedImage->video_id = $episode_id;
                            $VideoExtractedImage->image_original_name = $episode_id;
                            $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $episode_id . '_' . $rand . '_' . $index . '.webp');
                            $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $episode_id . '_' . $randportrait . '_' . $index . '.webp');
                            $VideoExtractedImage->image_original_name = $episode_id . '_' . $rand . '_' . $index . '.webp';
                            $VideoExtractedImage->save();
                
                        } catch (\Exception $e) {
                            dd($e->getMessage());
                        }
                    }

                }
                
                $episode_title = Episode::find($episode_id);
                $title =$episode_title->title; 
            
                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['Episode_id'] = $episode_id;
                $value['episode_title'] = $title;
                $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);
                return $value;
            }
            else 
            {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.'; 
                return response()->json($value);
            }
            
        }elseif($pack == "Business" && $settings->transcoding_access  == 1){

            if($file != '') {     

                $rand = Str::random(16);
                $path = $rand . '.' . $file->getClientOriginalExtension();
                $request->file->storeAs('public', $path);
                $file = $request->file->getClientOriginalName();
                $newfile = explode(".mp4",$file);
                $file_folder_name = $newfile[0];

                $storepath  = URL::to('/storage/app/public/'.$path);
                $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
                $storepath  = URL::to('/storage/app/public/'.$path);

                //  Episode duration 
                $getID3 = new getID3;
                $Video_storepath  = storage_path('app/public/'.$path);       
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];

                $video = new Episode();
                $video->title = $file_folder_name;
                $video->mp4_url = $path;
                $video->series_id = $series_id;
                $video->season_id = $season_id;
                $video->image = 'default_image.jpg';
                $video->type = 'm3u8';
                $video->status = 0;
                $video->disk = 'public';
                $video->status = 0;
                $video->path = $path;
                $video->mp4_url = $storepath;
                //  $video->user_id = Auth::user()->id;
                $video->episode_order = Episode::where('season_id',$season_id)->max('episode_order') + 1 ;
                $video->duration = $Video_duration;
                $video->save();
                
                $episode_id = $video->id;
                
                $outputFolder = storage_path('app/public/frames');

                if (!is_dir($outputFolder)) {
                    mkdir($outputFolder, 0755, true);
                }
             
            if(Enable_Extract_Image() == 1){
                // extractImageFromVideo
            
                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videoFrame = $ffmpeg->open($Video_storepath);
                
                // Define the dimensions for the frame (16:9 aspect ratio)
                $frameWidth = 1280;
                $frameHeight = 720;
                
                // Define the dimensions for the frame (9:16 aspect ratio)
                $frameWidthPortrait = 1080;  // Set the desired width of the frame
                $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
                $randportrait = 'portrait_' . $rand;
                
                $interval = 5; // Interval for extracting frames in seconds
                $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                $totalDuration = intval($totalDuration);


                if ( 600 < $totalDuration) { 
                    $timecodes = [5, 120, 240, 360, 480]; 
                } else { 
                    $timecodes = [5, 10, 15, 20, 25]; 
                }

                
                foreach ($timecodes as $index => $time) {
                    $imagePortraitPath = public_path("uploads/images/{$episode_id}_{$randportrait}_{$index}.jpg");
                    $imagePath = public_path("uploads/images/{$episode_id}_{$rand}_{$index}.jpg");
            
                    try {
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
            
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
            
                        $VideoExtractedImage = new VideoExtractedImages();
                        $VideoExtractedImage->user_id = Auth::user()->id;
                        $VideoExtractedImage->socure_type = 'Episode';
                        $VideoExtractedImage->video_id = $episode_id;
                        $VideoExtractedImage->image_original_name = $episode_id;
                        $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $episode_id . '_' . $rand . '_' . $index . '.jpg');
                        $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $episode_id . '_' . $randportrait . '_' . $index . '.jpg');
                        $VideoExtractedImage->image_original_name = $episode_id . '_' . $rand . '_' . $index . '.jpg';
                        $VideoExtractedImage->save();

                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            
            }

                $Playerui = Playerui::first();
                if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){
                    ConvertEpisodeVideoWatermark::dispatch($video,$storepath);
                }else{
                    if(Enable_4k_Conversion() == 1){
                        Convert4kEpisodeVideo::dispatch($video,$storepath);
                    }else{
                        ConvertEpisodeVideo::dispatch($video,$storepath);
                    }
                } 


                $episode_id = $video->id;
                $episode_title = Episode::find($episode_id);
                $title =$episode_title->title; 
                $value['success'] = 1;
                $value['message'] = 'Uploaded Successfully!';
                $value['Episode_id'] = $episode_id;
                $value['episode_title'] = $title;
                $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);
                return $value;
            }
            else {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.'; 
                return response()->json($value);
            }
        }
        else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
        }
    }

    public function DeleteEpisodeRecord(Request $request)
    {
        $file_folder_name = $request->input('file_folder_name');
        $file_folder_name_without_extension = pathinfo($file_folder_name, PATHINFO_FILENAME);
        // dd($file_folder_name_without_extension);

        // Find the episode based on the uploaded file name
        $episode = Episode::where('title', $file_folder_name_without_extension)->first();

        if ($episode) {
            $episode->delete();
            // dd($episode);
            return response()->json(['success' => true, 'message' => 'Episode deleted successfully']);
        } else {
            // dd($episode);
            return response()->json(['success' => false, 'message' => 'Episode not found']);
        }
    }



    public function createSlug($title, $id = 0)
    {
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Series::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function createSlugEpisode($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugsEpisode($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugsEpisode($slug, $id = 0)
    {
        return Episode::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function build_video_thumbnail($video_path,$movie, $thumb_path) {

    // Create a temp directory for building.
            $temp = storage_path('app/public'). "/build";
            if (!file_exists($temp)) {
                File::makeDirectory($temp);
            }

    // Use FFProbe to get the duration of the video.
            $ffprobe = \FFMpeg\FFProbe::create();
            $duration = $ffprobe->streams($video_path)
            ->videos()
            ->first()                  
            ->get('duration'); 
    // If we couldn't get the direction or it was zero, exit.
            if (empty($duration)) {
                return;
            }

    // Create an FFMpeg instance and open the video.

    // This array holds our "points" that we are going to extract from the
    // video. Each one represents a percentage into the video we will go in
    // extracitng a frame. 0%, 10%, 20% ..
            $points = range(0, 100, 10);

    // This will hold our finished frames.
            $frames = [];

            foreach ($points as $point) {
            $video = FFMpeg::fromDisk('public')->open($movie);

        // Point is a percent, so get the actual seconds into the video.
                $time_secs = floor($duration * ($point / 100));

        // Created a var to hold the point filename.
                $point_file = "$temp/$point.jpg";
        // Extract the frame.
                $frame = $video->frame(TimeCode::fromSeconds($time_secs));
                $frame->save($point_file);

        // If the frame was successfully extracted, resize it down to
        // 320x200 keeping aspect ratio.
                if (file_exists($point_file)) {
                    $img = Image::make($point_file)->resize(150, 150, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save($point_file, 40);
                    $img->destroy();
                }
        // If the resize was successful, add it to the frames array.
                if (file_exists($point_file)) {
                    $frames[] = $point_file;
                }
            }
    // If we have frames that were successfully extracted.
            if (!empty($frames)) {

        // We show each frame for 100 ms.
                $durations = array_fill(0, count($frames), 100);
        // Create a new GIF and save it.
                $gc = new GifCreator();
                $gc->create($frames, $durations, 0);
                file_put_contents(storage_path('app/public').'/'.$thumb_path.'.gif', $gc->getGif());

        // Remove all the temporary frames.
                foreach ($frames as $file) {
                    unlink($file);
                }
            }
        }


        public function TitleValidation(Request $request) {
            $title = $request->get('title');
              
              $uid = Auth::user();
              $Series = Series::where('title','=',$title)->first();
              if (!empty($Series))
              {
                  $value['Series'] = "yes";
                  return $value;  
      
              }else{
                  $value['Series'] = "no";
                  return $value;  
              }
      
          }
          public function create_episodeold(Request $request)
    {
        
        $data = $request->all();
        // dd($data);
        $settings =Setting::first();

        if(!empty($data['ppv_price'])){
            $ppv_price = $data['ppv_price'];
        }elseif(!empty($data['ppv_status']) || $settings->ppv_status == 1){
            $ppv_price = $settings->ppv_price;
        }else{
            $ppv_price = null;

        }

        $path = public_path().'/uploads/episodes/';
        $image_path = public_path().'/uploads/images/';
        
        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){
               if($image != ''  && $image != null){
                   $file_old = $image_path.$image;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $image;
            //   $data['image']  = $file->getClientOriginalName();
            $data['image'] =  str_replace(' ', '_', $file->getClientOriginalName());
              $file->move($image_path, $data['image']);
        } else {
            $data['image'] = 'placeholder.jpg';
        }
        
        if(empty($data['active'])){
            $data['active'] = 0;
        }
        if(empty($data['views'])){
            $data['views'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        if(empty($data['skip_recap'])){
            $data['skip_recap'] = "";
        }
        if(empty($data['skip_intro'])){
            $data['skip_intro'] = "";
        }
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
        $data['ppv_status'] = 1;
        }


        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }
       
        
        $episode_upload = (isset($data['episode_upload'])) ? $data['episode_upload'] : '';

        if($episode_upload != '' && $request->hasFile('episode_upload')) {

            $ffprobe = \FFMpeg\FFProbe::create();
            $disk = 'public';
            $data['duration'] = $ffprobe->streams($request->episode_upload)
            ->videos()
            ->first()                  
            ->get('duration'); 

            $rand = Str::random(16);
            $path = $rand . '.' . $request->episode_upload->getClientOriginalExtension();
            $request->episode_upload->storeAs('public', $path);
            $data['path'] = $rand;

            $thumb_path = 'public';
            $this->build_video_thumbnail($request->episode_upload,$path, $rand);

            $data['mp4_url'] = URL::to('/').'/storage/app/public/'.$path;
            $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
            $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
            $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
            $converted_name = ConvertVideoForStreaming::handle($path);

            ConvertVideoForStreaming::dispatch($path);
        }
              $episode = Episode::create($data);              
              $episode->skip_recap =  $data['skip_recap'];
              $episode->recap_start_time =  $data['recap_start_time'];
              $episode->recap_end_time =  $data['recap_end_time'];
              $episode->skip_intro =  $data['skip_intro'];
              $episode->intro_start_time =  $data['intro_start_time'];
              $episode->intro_end_time =  $data['intro_end_time'];
              $episode->ppv_price =  $ppv_price;
              $episode->ppv_status =  $data['ppv_status'];
              $episode->episode_description =  $data['episode_description'];
              $episode->save();


        return Redirect::to('admin/season/edit/'.$data['series_id'].'/'.$data['season_id'])->with(array('note' => 'New Episode Successfully Added!', 'note_type' => 'success') );
    }

    public function episode_order(Request $request)
    {

        $input = $request->all();
        $position = $_POST['position'];

        $i=1;
        foreach($position as $key =>$value ){
          $videocategory = Episode::find($value);
          $videocategory->episode_order =$i;
          $videocategory->save();
          $i++;
        }

        $series = Series::find($request->seriesid);
        $episodes = Episode::where('series_id' ,'=', $request->seriesid)
                    ->where('season_id' ,'=', $request->season_id)->orderBy('episode_order')->get();

        $data = array( 'episodes' => $episodes );
        return View::make('admin.series.order_episodes', $data);
     }

    public function series_slider_update(Request $request)
    {
        try {
            $video = Series::where('id',$request->video_id)->update([
                'banner' => $request->banner_status,
            ]);

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    }

    public function episode_slider_update(Request $request)
    {
        try {
            $video = Episode::where('id',$request->video_id)->update([
                'banner' => $request->banner_status,
            ]);

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    }

    public function ChannelSeriesIndex()
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
        }else{

            $videos =    Series::where('active', '=',0)
            ->join('channels', 'channels.id','=','series.user_id')
            ->select( 'series.*','channels.channel_name as username')
            ->where("series.uploaded_by", "Channel")
            ->orderBy('series.created_at', 'DESC')->paginate(9);

            // dd($videos);
            $data = array(
                'videos' => $videos,
                // 'channelvideos' => $channelvideos,
                );

            return View('admin.series.SeriesApproval.ChannelSeriesApproval', $data);
        }
    }
       public function ChannelSeriesApproval($id)
       {
           $video = Series::findOrFail($id);
           $video->active = 1;
           $video->save();

           $settings = Setting::first();
           $user_id = $video->user_id;
           $Channel = Channel::findOrFail($video->user_id);
           try {
               \Mail::send('emails.admin_channel_approved', array(
                   'website_name' => $settings->website_name,
                   'Channel' => $Channel
               ) , function ($message) use ($Channel)
               {
                   $message->from(AdminMail() , GetWebsiteName());
                   $message->to($Channel->email, $Channel->channel_name)
                       ->subject('Content has been Submitted for Approved By Admin');
               });
               
               $email_log      = 'Mail Sent Successfully Approved Content';
               $email_template = "Approved";
               $user_id = $user_id;
   
               Email_sent_log($user_id,$email_log,$email_template);
   
          } catch (\Throwable $th) {
   
               $email_log      = $th->getMessage();
               $email_template = "Approved";
               $user_id = $user_id;
   
               Email_notsent_log($user_id,$email_log,$email_template);
          }
   
           return Redirect::back()->with('message','Your video will be available shortly after we process it');

          }

          public function ChannelSeriesReject($id)
          {
            $video = Series::findOrFail($id);
            $video->active = 2;
            $video->save();  
            
            
        $settings = Setting::first();
        $user_id = $video->user_id;
        $Channel = Channel::findOrFail($video->user_id);
        try {
            \Mail::send('emails.admin_channel_rejected', array(
                'website_name' => $settings->website_name,
                'Channel' => $Channel
            ) , function ($message) use ($Channel)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($Channel->email, $Channel->channel_name)
                    ->subject('Content has been Submitted for Rejected By Admin');
            });
            
            $email_log      = 'Mail Sent Successfully Rejected Content';
            $email_template = "Rejected";
            $user_id = $user_id;

            Email_sent_log($user_id,$email_log,$email_template);

       } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "Rejected";
            $user_id = $user_id;

            Email_notsent_log($user_id,$email_log,$email_template);
       }


            return Redirect::back()->with('message','Your video will be available shortly after we process it');
 
             }


        public function CPPSeriesIndex()
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
            }else{
            // $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
    
            $videos =    Series::where('active', '=',0)
            ->join('moderators_users', 'moderators_users.id','=','series.user_id')
            ->select('moderators_users.username', 'series.*')
            ->where("series.uploaded_by", "CPP")
            ->orderBy('series.created_at', 'DESC')->paginate(9);
                // dd($videos);
                $data = array(
                    'videos' => $videos,
                    // 'channelvideos' => $channelvideos,
                    );
    // dd($videos);
    
    return View('admin.series.SeriesApproval.CppSeriesApproval', $data);

            }
        }
    public function CPPSeriesApproval($id)
    {
        $video = Series::findOrFail($id);
        $video->active = 1;
        $video->save();

        $settings = Setting::first();
        $user_id = $video->user_id;
        $ModeratorsUser = ModeratorsUser::findOrFail($video->user_id);
        try {
            \Mail::send('emails.admin_cpp_approved', array(
                'website_name' => $settings->website_name,
                'ModeratorsUser' => $ModeratorsUser
            ) , function ($message) use ($ModeratorsUser)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)
                    ->subject('Content has been Submitted for Approved By Admin');
            });
            
            $email_log      = 'Mail Sent Successfully Approved Content';
            $email_template = "Approved";
            $user_id = $user_id;

            Email_sent_log($user_id,$email_log,$email_template);

       } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "Approved";
            $user_id = $user_id;

            Email_notsent_log($user_id,$email_log,$email_template);
       }

        return Redirect::back()->with('message','Your video will be available shortly after we process it');

        }

        public function CPPSeriesReject($id)
        {
            $video = Series::findOrFail($id);
            $video->active = 2;
            $video->save(); 
            
            
        $settings = Setting::first();
        $user_id = $video->user_id;
        $ModeratorsUser = ModeratorsUser::findOrFail($video->user_id);
        try {
            \Mail::send('emails.admin_cpp_rejected', array(
                'website_name' => $settings->website_name,
                'ModeratorsUser' => $ModeratorsUser
            ) , function ($message) use ($ModeratorsUser)
            {
                $message->from(AdminMail() , GetWebsiteName());
                $message->to($ModeratorsUser->email, $ModeratorsUser->username)
                    ->subject('Content has been Submitted for Rejected By Admin');
            });
            
            $email_log      = 'Mail Sent Successfully Rejected Content';
            $email_template = "Rejected";
            $user_id = $user_id;

            Email_sent_log($user_id,$email_log,$email_template);

       } catch (\Throwable $th) {

            $email_log      = $th->getMessage();
            $email_template = "Rejected";
            $user_id = $user_id;

            Email_notsent_log($user_id,$email_log,$email_template);
       }

            return Redirect::back()->with('message','Your video will be available shortly after we process it');

            }
    public function EpisodeUploadEdit($id){

        $video = Episode::findOrFail($id);
        // dd($id);

        $StorageSetting = StorageSetting::first();
        if($StorageSetting->site_storage == 1){
            $dropzone_url =  URL::to('admin/EpisodeVideoUpload');
        }elseif($StorageSetting->aws_storage == 1){
            $dropzone_url =  URL::to('admin/AWSEpisodeVideoUpload');
        }else{ 
            $dropzone_url =  URL::to('admin/EpisodeVideoUpload');
        }

        $data = array(
            'videos' => $video,
            'dropzone_url' => $dropzone_url,
            );

        return View('admin.series.edit_episode_video', $data);
    }

    public function EpisodeVideoUpload(Request $request){

        $value = array();
        $data = $request->all();
        $id = $data['Episodeid'];
        $video = Episode::findOrFail($id);

        $file = (isset($data['file'])) ? $data['file'] : '';

        $package = User::where('id',1)->first();
        $pack = $package->package;
        $mp4_url = $data['file'];
        $settings = Setting::first();

        if($pack != "Business" || $pack == "Business" && $settings->transcoding_access  == 0){

        if($file != '') {        
        $rand = Str::random(16);
        $path = $rand . '.' . $file->getClientOriginalExtension();
        $request->file->storeAs('public', $path);
        $storepath  = URL::to('/storage/app/public/'.$path);
        $file = $request->file->getClientOriginalName();

                //  Episode duration 
                $getID3 = new getID3;
                $Video_storepath  = storage_path('app/public/'.$path);       
                $VideoInfo = $getID3->analyze($Video_storepath);
                $Video_duration = $VideoInfo['playtime_seconds'];

        $newfile = explode(".mp4",$file);
        $file_folder_name = $newfile[0];       
            $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
            $episode = Episode::findOrFail($id);
            $episode->mp4_url = $storepath;
            $episode->type = 'upload';
            $episode->save(); 
            $episode_id = $episode->id;
        $episode_title = Episode::find($episode_id);
        $title =$episode_title->title; 
        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['Episode_id'] = $episode_id;
        $value['episode_title'] = $title;
        $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);
        return $value;
        }else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
            }
        
    }elseif($pack == "Business" && $settings->transcoding_access  == 1){
        if($file != '') {     
        $rand = Str::random(16);
        $path = $rand . '.' . $file->getClientOriginalExtension();
        $request->file->storeAs('public', $path);
        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4",$file);
        $file_folder_name = $newfile[0];
        $storepath  = URL::to('/storage/app/public/'.$path);

        $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
            
        $storepath  = URL::to('/storage/app/public/'.$path);

            //  Episode duration 
            $getID3 = new getID3;
            $Video_storepath  = storage_path('app/public/'.$path);       
            $VideoInfo = $getID3->analyze($Video_storepath);
            $Video_duration = $VideoInfo['playtime_seconds'];

            $video = Episode::findOrFail($id);
            $video->mp4_url = $path;
            $video->type = 'm3u8';
            $video->status = 0;
            $video->active = 0;
            $video->disk = 'public';
            $video->path = $path;
            $video->mp4_url = $storepath;
            $video->duration = $Video_duration;
            $video->save();

            $Playerui = Playerui::first();
            if(@$Playerui->video_watermark_enable == 1 && !empty($Playerui->video_watermark)){
                ConvertEpisodeVideoWatermark::dispatch($video,$storepath);
            }else{
                if(Enable_4k_Conversion() == 1){
                    Convert4kEpisodeVideo::dispatch($video,$storepath);
                }else{
                    ConvertEpisodeVideo::dispatch($video,$storepath);
                }
            } 
            
        $episode_id = $video->id;
        $episode_title = Episode::find($episode_id);
        $title =$episode_title->title; 
        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['Episode_id'] = $episode_id;
        $value['episode_title'] = $title;
        $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);

        return $value;
            
            

        }else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
            }

        }else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
            }


        }
        

        public function indexCPPPartner(Request $request)
        {
            try {
           
            $ModeratorsUser = ModeratorsUser::get();
            $Series = Series::where("uploaded_by","!=","CPP")->orWhere("uploaded_by",null)->get();

            $data = array(
                'setting'   => Setting::first(), 
                'ModeratorsUser' => $ModeratorsUser,
                'Series' => $Series,
            );

            return view('admin.series.move_series.move_cpp_series',$data);
               
            } catch (\Throwable $th) {
                return abort(404);
            }
        }

        public function MoveCPPPartner(Request $request)
        {
            $data = $request->all();

            $Seriesid = $data['Series_data'];
            $cpp_id = $data['cpp_users'];

            $ModeratorsUser = ModeratorsUser::get();
            $Series = Series::where("id",$Seriesid)->first();
            $Series->user_id = $cpp_id;
            $Series->uploaded_by = 'CPP';
            $Series->CPP_commission_percentage = $request->CPP_commission_percentage;
            $Series->save();

            return Redirect::back()->with('message','Your video moved to selected partner');
        }

        public function indexChannelPartner(Request $request)
        {

            $channel = Channel::get();
            $Series = Series::where("uploaded_by","!=","Channel")->orWhere("uploaded_by",null)->get();

            $data = array(
                
                'channel' => $channel,
                'Series' => $Series,

            );

            return view('admin.series.move_series.move_channel_move_series',$data);
            
        }
        
        public function MoveChannelPartner(Request $request)
        {
            $data = $request->all();

            $Seriesid = $data['Series_data'];
            $channel_id = $data['channel_users'];

            $Series = Series::where("id",$Seriesid)->first();
            $Series->user_id = $channel_id;
            $Series->uploaded_by = 'Channel';
            $Series->save();

            return Redirect::back()->with('message','Your video moved to selected partner');
        }

        public function filedelete($id)
        {
            $video = Episode::findOrFail($id);
            $filename = $video->path . ".mp4";
            $path = storage_path("app/public/" . $filename);
    
            if (file_exists($path)) {
                unlink($path);
            } else {
            }
            return Redirect::back()->with(
                "message",
                "Your video will be available shortly after we process it"
            );
        }


        public function AWSEpisodeUpload(Request $request){

            $value = array();
            $data = $request->all();
            $series_id = $data['series_id'];
            $season_id = $data['season_id'];
    
            $validator = Validator::make($request->all(), [
               'file' => 'required|mimes:video/mp4,video/x-m4v,video/*'
               
            ]);
            $file = (isset($data['file'])) ? $data['file'] : '';
    
            // https://webnexs.org/flicknexs/content/uploads/episodes/6.mp4
            $package = User::where('id',1)->first();
            $pack = $package->package;
            $mp4_url = $data['file'];
            $settings = Setting::first();
            $StorageSetting = StorageSetting::first();
    
            if($pack != "Business" || $pack == "Business" && $settings->transcoding_access  == 0){
    
            if($file != '') {        

                $file = $request->file('file');
                $file_folder_name =  $file->getClientOriginalName();
                // $name = time() . $file->getClientOriginalName();
                $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
                $filePath = $StorageSetting->aws_episode_path.'/'. $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $storepath = $path.$filePath;

                $file = $request->file->getClientOriginalName();
                $newfile = explode(".mp4",$file);
                $file_folder_name = $newfile[0];   
                $file = $request->file('file');

                $ffprobe =  \FFMpeg\FFProbe::create();
                $duration = $ffprobe->format($mp4_url)->get('duration');
                $Video_duration = explode(".", $duration)[0];
    
            $newfile = explode(".mp4",$file);
            $file_folder_name = $newfile[0];       
             $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
             $episode = new Episode();
             $episode->title = $file_folder_name;
             $episode->mp4_url = $storepath;
             $episode->series_id = $series_id;
             $episode->season_id = $season_id;
             $episode->image = 'default_image.jpg';
             $episode->type = 'upload';
             $episode->status = 0;
            $episode->duration = $Video_duration;
            $episode->episode_order = Episode::where('season_id',$season_id)->max('episode_order') + 1 ;
    
             $episode->save(); 
             $episode_id = $episode->id;
            $episode_title = Episode::find($episode_id);
            $title =$episode_title->title; 
            
            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['Episode_id'] = $episode_id;
            $value['episode_title'] = $title;
            $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);
            return $value;
            }else {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.'; 
               return response()->json($value);
               }
            
        }elseif($pack == "Business" && $settings->transcoding_access  == 1){
            if($file != '') {     


                $file = $request->file('file');
                $file_folder_name =  $file->getClientOriginalName();
                // $name = time() . $file->getClientOriginalName();
                $name_mp4 =  $file->getClientOriginalName();
                $name_mp4 = null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        
                $newfile = explode(".mp4",$name_mp4);
                $namem3u8 = $newfile[0].'.m3u8';   
                $namem3u8 = null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        
                $filePath = $StorageSetting->aws_episode_path.'/'. $name_mp4;
                $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $namem3u8;
                $transcode_path_mp4 = @$StorageSetting->aws_episode_path.'/'. $name_mp4;
                Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
                $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
                $storepath = $path.$transcode_path_mp4;
                $transcode_path = $path.$transcode_path;
                // print_r($transcode_path);exit;
    
                $file = $request->file->getClientOriginalName();

                $newfile = explode(".mp4",$file);
                $file_folder_name = $newfile[0];     
                $file = $request->file('file');

              //  Episode duration 
              $ffprobe =  \FFMpeg\FFProbe::create();
              $duration = $ffprobe->format($mp4_url)->get('duration');
              $Video_duration = explode(".", $duration)[0];
    
             $video = new Episode();
             $video->title = $file_folder_name;
             $video->mp4_url = $storepath;
             $video->path = $transcode_path;
             $video->series_id = $series_id;
             $video->season_id = $season_id;
             $video->image = 'default_image.jpg';
             $video->type = 'aws_m3u8';
             $video->status = 0;
             $video->disk = 'public';
             $video->status = 0;
            //  $video->user_id = Auth::user()->id;
            $video->episode_order = Episode::where('season_id',$season_id)->max('episode_order') + 1 ;
            $video->duration = $Video_duration;
             $video->save();
        
             $episode_id = $video->id;
            $episode_title = Episode::find($episode_id);
            $title =$episode_title->title; 
            $value['success'] = 1;
            $value['message'] = 'Uploaded Successfully!';
            $value['Episode_id'] = $episode_id;
            $value['episode_title'] = $title;
            $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);
    
            return $value;
             
              
    
            }else {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.'; 
               return response()->json($value);
               }
    
            }else {
                $value['success'] = 2;
                $value['message'] = 'File not uploaded.'; 
               return response()->json($value);
               }
    
    
            }


            
    public function AWSEpisodeVideoUpload(Request $request){

        $value = array();
        $data = $request->all();
        $id = $data['Episodeid'];
        $video = Episode::findOrFail($id);
        $StorageSetting = StorageSetting::first();

        $file = (isset($data['file'])) ? $data['file'] : '';

        $package = User::where('id',1)->first();
        $pack = $package->package;
        $mp4_url = $data['file'];
        $settings = Setting::first();

        if($pack != "Business" || $pack == "Business" && $settings->transcoding_access  == 0){

        if($file != '') {        

            $file = $request->file('file');
            $file_folder_name =  $file->getClientOriginalName();
            // $name = time() . $file->getClientOriginalName();
            $name = $file->getClientOriginalName() == null ? str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) : str_replace(' ', '_', 'S3'.$file->getClientOriginalName()) ;        
            $filePath = $StorageSetting->aws_episode_path.'/'. $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
            $storepath = $path.$filePath;
            $file = $request->file('file');

                //  Episode duration 
                $ffprobe =  \FFMpeg\FFProbe::create();
                $duration = $ffprobe->format($mp4_url)->get('duration');
                $Video_duration = explode(".", $duration)[0];
                // $getID3 = new getID3();
                // $Video_storepath = $file;
                // $VideoInfo = $getID3->analyze($Video_storepath);
                // $Video_duration = $VideoInfo["playtime_seconds"];

        $newfile = explode(".mp4",$file);
        $file_folder_name = $newfile[0];       
            $original_name = ($request->file->getClientOriginalName()) ? $request->file->getClientOriginalName() : '';
            $episode = Episode::findOrFail($id);
            $episode->mp4_url = $storepath;
            $episode->duration = $Video_duration;
            $episode->type = 'upload';
            $episode->save(); 
            $episode_id = $episode->id;
        $episode_title = Episode::find($episode_id);
        $title =$episode_title->title; 
        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['Episode_id'] = $episode_id;
        $value['episode_title'] = $title;
        $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);
        return $value;
        }else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
            }
        
    }elseif($pack == "Business" && $settings->transcoding_access  == 1){
        if($file != '') {     

        $file = $request->file->getClientOriginalName();
        $newfile = explode(".mp4",$file);
        $file_folder_name = $newfile[0];

        $file = $request->file('file');
        $file_folder_name =  $file->getClientOriginalName();
        // $name = time() . $file->getClientOriginalName();
        $name_mp4 =  $file->getClientOriginalName();
        $name_mp4 = null ? str_replace(' ', '_', 'S3'.$name_mp4) : str_replace(' ', '_', 'S3'.$name_mp4) ;        
        $newfile = explode(".mp4",$name_mp4);
        $namem3u8 = $newfile[0].'.m3u8';   
        $namem3u8 = null ? str_replace(' ', '_',$namem3u8) : str_replace(' ', '_',$namem3u8) ;        
        $filePath = $StorageSetting->aws_episode_path.'/'. $name_mp4;
        $transcode_path = @$StorageSetting->aws_transcode_path.'/'. $namem3u8;
        $transcode_path_mp4 = @$StorageSetting->aws_episode_path.'/'. $name_mp4;
        Storage::disk('s3')->put($transcode_path_mp4, file_get_contents($file));
        $path = 'https://' . env('AWS_BUCKET').'.s3.'. env('AWS_DEFAULT_REGION') . '.amazonaws.com' ;
        $storepath = $path.$transcode_path_mp4;
        $transcode_path = $path.$transcode_path;

        $file = $request->file('file');

            //  Episode duration 
            
            $ffprobe =  \FFMpeg\FFProbe::create();
            $duration = $ffprobe->format($mp4_url)->get('duration');
            $Video_duration = explode(".", $duration)[0];
            // $getID3 = new getID3();
            // $Video_storepath = $file;
            // $VideoInfo = $getID3->analyze($Video_storepath);
            // $Video_duration = $VideoInfo["playtime_seconds"];

            $video = Episode::findOrFail($id);
            $video->mp4_url = $storepath;
            $video->path = $transcode_path;
            $video->type = 'aws_m3u8';
            $video->status = 0;
            $video->disk = 'public';
            $video->duration = $Video_duration;
            $video->save();


        $episode_id = $video->id;
        $episode_title = Episode::find($episode_id);
        $title =$episode_title->title; 
        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['Episode_id'] = $episode_id;
        $value['episode_title'] = $title;
        $value['episode_duration'] = gmdate('H:i:s', $episode_title->duration);

        return $value;
            
            

        }else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
            }

        }else {
            $value['success'] = 2;
            $value['message'] = 'File not uploaded.'; 
            return response()->json($value);
            }


        }

        public function episode_ads_position(Request $request)
        {
            try {

                $Advertisement = Advertisement::whereNotNull('ads_path')->where('ads_position',$request->ads_position)
                ->where('status',1)->get();
    
                $response = array(
                    'status'  => true,
                    'message' => 'Successfully Retrieve Pre Advertisement Episode',
                    'episode_ads'    => $Advertisement ,
                );
    
            } catch (\Throwable $th) {
    
                $response = array(
                    'status' => false,
                    'message' =>  $th->getMessage()
                );
            }
            return response()->json($response, 200);
        }

        public function ExtractedImage(Request $request)
        {
            try {
                // print_r($request->all());exit;
                $value = [];
    
                $ExtractedImage =  VideoExtractedImages::where('video_id',$request->episode_id)->where('socure_type','Episode')->get();
               
                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["Episode_id"] = $request->episode_id;
                $value["ExtractedImage"] = $ExtractedImage;
    
    
                return $value;
    
            } catch (\Throwable $th) {
                throw $th;
            }
    
        }


        
        
    public function BunnycdnEpisodelibrary(Request $request)
    {
        $data = $request->all();
        $value = [];

           // Bunny Cdn get Episodes 
                
           $storage_settings = StorageSetting::first();

           if(!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 
           && !empty($storage_settings->bunny_cdn_hostname) && !empty($storage_settings->bunny_cdn_storage_zone_name) 
           && !empty($storage_settings->bunny_cdn_ftp_access_key)  ){
               
               $videolibraryurl = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";
               
               $ch = curl_init();
               
               $options = array(
                   CURLOPT_URL => $videolibraryurl,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_HTTPHEADER => array(
                       "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                       'Content-Type: application/json',
                   ),
               );
               
               curl_setopt_array($ch, $options);
               
               $response = curl_exec($ch);
               $videolibrary = json_decode($response, true);
               curl_close($ch);
               // dd($videolibrary); ApiKey

           }else{
               $decodedResponse = [];
               $videolibrary = [];

           }

           if(count($videolibrary) > 0){

                foreach($videolibrary as $key => $value){



                    if( $value['Id'] == $request->episodelibrary_id){



                        $videolibrary_id = $value['Id'];
                        $videolibrary_ApiKey = $value['ApiKey']; 
                        $videolibrary_PullZoneId = $value['PullZoneId']; 
                        break;
                    }else{
                        $videolibrary_id = null;
                        $videolibrary_ApiKey = null; 
                        $videolibrary_PullZoneId = null; 
                    }
                }
         

           }else{
                $videolibrary_id = null;
                $videolibrary_ApiKey = null; 
                $videolibrary_PullZoneId = null; 
            }

        
            if($videolibrary_id != null && $videolibrary_ApiKey != null){

                $client = new \GuzzleHttp\Client();
                // $videolibrary_PullZoneId
                $client = new \GuzzleHttp\Client();
                
                $PullZone = $client->request('GET', 'https://api.bunny.net/pullzone/' . $videolibrary_PullZoneId . '?includeCertificate=false', [
                    'headers' => [
                        'AccessKey' => $storage_settings->bunny_cdn_access_key,
                        'accept' => 'application/json',
                    ],
                ]);

                $PullZoneData = json_decode($PullZone->getBody()->getContents());

                    if(!empty($PullZoneData) && !empty($PullZoneData->Name)){
                        // vz-2117a0a6-f55  https://vz-5c4af3d1-257.b-cdn.net
                        $PullZoneURl = 'https://'. $PullZoneData->Name. '.b-cdn.net';
                    }else{
                        $PullZoneURl = null;
                    }
                    // dd($PullZoneURl);

                $response = $client->request('GET', 'https://video.bunnycdn.com/library/' . $videolibrary_id . '/videos?page=1&itemsPerPage=100&orderBy=date', [
                        'headers' => [
                        'AccessKey' => $videolibrary_ApiKey,
                        'accept' => 'application/json',
                    ],
                ]);
                $streamvideos = $response->getBody()->getContents();
                // echo $response->getBody();
                // exit;
           
            }else{
                $streamvideos = [];
            }

        // print_r($response);exit;
            // return $streamvideos;
            $responseData = [
                'streamvideos' => $streamvideos,
                'PullZoneURl' => $PullZoneURl,
            ];
        
            return $responseData;
        
    }

    
    public function StreamBunnyCdnEpisode(Request $request)
    {
        $data = $request->all();
        $value = [];

        if (!empty($data["stream_bunny_cdn_episode"])) {

            $Episode = new Episode();
            $Episode->disk = "public";
            $Episode->title = $data["stream_bunny_cdn_episode"];
            $Episode->url = $data["stream_bunny_cdn_episode"];
            $Episode->series_id = $data["series_id"];
            $Episode->season_id = $data["season_id"];
            $Episode->type = "bunny_cdn";
            $Episode->active = 0;
            $Episode->episode_order = Episode::where('season_id',$data["season_id"])->max('episode_order') + 1 ;
            $Episode->image = default_vertical_image();
            $Episode->tv_image = default_horizontal_image();
            $Episode->player_image = default_horizontal_image();
            $Episode->user_id = Auth::user()->id;
            $Episode->save();

            $Episode_id = $Episode->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["Episode_id"] = $Episode_id;

            return $value;
        }
    }

    
    private function UploadEpisodeBunnyCDNStream($storage_settings, $libraryid, $data, $season_id)
    {
        // Bunny CDN get Videos
        $mp4_url = $data['file'];

        // Handle temporary file and move to permanent location
        if ($mp4_url instanceof \Illuminate\Http\UploadedFile) {
            // Retrieve the original name of the file
            $originalName = $mp4_url->getClientOriginalName();
            
            // Replace spaces with underscores to avoid issues in URLs
            $sanitizedOriginalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);

            
            // Store the file with its original name
            $filePath = $mp4_url->storeAs('uploads/videos', $sanitizedOriginalName, 'public');
            
            // Get the full path to the stored file
            $mp4_url = public_path('../storage/app/public/' . $filePath);
        }
        // Validate the MP4 URL
        if (empty($mp4_url) || !file_exists($mp4_url) || !is_readable($mp4_url)) {
            \Log::error("Invalid file: {$mp4_url}");
            return response()->json(['error' => 'The file does not exist or is not readable.'], 400);
        }
    
        $storage_settings = StorageSetting::first();

    if (!empty($storage_settings) && $storage_settings->bunny_cdn_storage == 1 
        && !empty($storage_settings->bunny_cdn_access_key)) {

        $libraryurl = "https://api.bunny.net/videolibrary?page=0&perPage=1000&includeAccessKey=false/";

        $ch = curl_init();

        $options = array(
            CURLOPT_URL => $libraryurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "AccessKey: {$storage_settings->bunny_cdn_access_key}",
                'Content-Type: application/json',
            ),
        );

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $librarys = json_decode($response, true);
        curl_close($ch);

    } else {
        $librarys = [];
    }
    
        if (count($librarys) > 0) {
            foreach ($librarys as $key => $value) {
                if ($value['Id'] == $libraryid) {
                    $library_id = $value['Id'];
                    $library_ApiKey = $value['ApiKey'];
                    $library_PullZoneId = $value['PullZoneId'];
                    break;
                } else {
                    $library_id = null;
                    $library_ApiKey = null;
                    $library_PullZoneId = null;
                }
            }
        } else {
            $library_id = null;
            $library_ApiKey = null;
            $library_PullZoneId = null;
        }
    
        if ($library_id != null && $library_ApiKey != null) {
            $client = new \GuzzleHttp\Client();
    
            try {
                $PullZone = $client->request('GET', 'https://api.bunny.net/pullzone/' . $library_PullZoneId . '?includeCertificate=false', [
                    'headers' => [
                        'AccessKey' => $storage_settings->bunny_cdn_access_key,
                        'accept' => 'application/json',
                    ],
                ]);
    
                $PullZoneData = json_decode($PullZone->getBody()->getContents());
    
                if (!empty($PullZoneData) && !empty($PullZoneData->Name)) {
                    $PullZoneURl = 'https://' . $PullZoneData->Name . '.b-cdn.net';
                } else {
                    $PullZoneURl = null;
                }
            } catch (\Exception $e) {
                Log::error("Error fetching Pull Zone: " . $e->getMessage());
                return response()->json(['error' => 'Failed to fetch Pull Zone'], 500);
            }
    
            $file_name = pathinfo($mp4_url, PATHINFO_FILENAME);
            $filename = str_replace(' ', '_', $file_name);
    
            // Step 1: Create the video entry in the library
            try {
                $response = $client->request('POST', "https://video.bunnycdn.com/library/{$libraryid}/videos", [
                    'json' => ['title' => $filename],
                    'headers' => [
                        'AccessKey' => $library_ApiKey,
                        'Accept' => 'application/json',
                    ]
                ]);
    
                $responseData = json_decode($response->getBody(), true);
                $guid = $responseData['guid'];
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                Log::error("Error creating video entry: " . $e->getMessage());
                return response()->json(['error' => 'Video entry creation failed'], 500);
            }
    
            // Step 2: Upload the video file
            try {
                $context = stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]);
    
                $videoData = @file_get_contents($mp4_url, false, $context);
    
                if ($videoData === false) {
                    Log::error("Unable to fetch video data from: " . $mp4_url);
                    return response()->json(['error' => 'Failed to fetch video data'], 400);
                }
    
                $response = $client->request('PUT', "https://video.bunnycdn.com/library/{$libraryid}/videos/{$guid}", [
                    'headers' => [
                        'AccessKey' => $library_ApiKey,
                        'Content-Type' => 'video/mp4'
                    ],
                    'body' => $videoData
                ]);
    
                $videoUrl = $PullZoneURl . '/' . $guid . '/playlist.m3u8';
                $responseuploaded = json_decode($response->getBody(), true);
                $statusCode = $responseuploaded['statusCode'];
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                Log::error("Error uploading video: " . $e->getMessage());
                return response()->json(['error' => 'Video upload failed'], 500);
            }
    
            if ($statusCode == 200) {
                // Proceed with saving Episode and extracting frames (if required)
                // Frame extraction logic stays the same, add similar validations where needed.
                $series_id = $data['series_id'];
                $season_id = $data['season_id'];
                    
                $Episode = new Episode();
                $Episode->disk = "public";
                $Episode->title = $file_name;
                $Episode->series_id = $series_id;
                $Episode->season_id = $season_id;
                $Episode->url = $videoUrl;
                $Episode->type = "bunny_cdn";
                $Episode->active = 0;
                $Episode->image = default_vertical_image();
                $Episode->tv_image = default_horizontal_image();
                $Episode->player_image = default_horizontal_image();
                $Episode->user_id = Auth::user()->id;
                $Episode->episode_order = Episode::where('season_id',$season_id)->max('episode_order') + 1 ;
                $Episode->save();

                $Episode_id = $Episode->id;


                if(Enable_Extract_Image() == 1){
                    // extractImageFromVideo
                    
                    $rand = Str::random(16);
                
                    $ffmpeg = \FFMpeg\FFMpeg::create();
                    $videoFrame = $ffmpeg->open($mp4_url);
                    
                    // Define the dimensions for the frame (16:9 aspect ratio)
                    $frameWidth = 1280;
                    $frameHeight = 720;
                    
                    // Define the dimensions for the frame (9:16 aspect ratio)
                    $frameWidthPortrait = 1080;  // Set the desired width of the frame
                    $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                    
                    $randportrait = 'portrait_' . $rand;
                    
                    $interval = 5; // Interval for extracting frames in seconds
                    $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                    $totalDuration = intval($totalDuration);
    
    
                    if ( 600 < $totalDuration) { 
                        $timecodes = [5, 120, 240, 360, 480]; 
                    } else { 
                        $timecodes = [5, 10, 15, 20, 25]; 
                    }
    
                    
                    foreach ($timecodes as $index => $time) {
                        $imagePortraitPath = public_path("uploads/images/{$Episode_id}_{$randportrait}_{$index}.jpg");
                        $imagePath = public_path("uploads/images/{$Episode_id}_{$rand}_{$index}.jpg");
                
                        try {
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($time))
                                ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
                
                            $videoFrame
                                ->frame(TimeCode::fromSeconds($time))
                                ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
                
                            $VideoExtractedImage = new VideoExtractedImages();
                            $VideoExtractedImage->user_id = Auth::user()->id;
                            $VideoExtractedImage->socure_type = 'Episode';
                            $VideoExtractedImage->video_id = $Episode_id;
                            $VideoExtractedImage->image_original_name = $Episode_id;
                            $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $Episode_id . '_' . $rand . '_' . $index . '.jpg');
                            $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $Episode_id . '_' . $randportrait . '_' . $index . '.jpg');
                            $VideoExtractedImage->image_original_name = $Episode_id . '_' . $rand . '_' . $index . '.jpg';
                            $VideoExtractedImage->save();
    
                        } catch (\Exception $e) {
                            dd($e->getMessage());
                        }
                    }
                
                }
                $value["success"] = 1;
                $value["message"] = "Uploaded Successfully!";
                $value["Episode_id"] = $Episode_id;
                return $value ;
                return response()->json(["success" => 1, "message" => "Uploaded Successfully!"]);
            } else {
                return $value ;
                Log::error("Unexpected status code: " . $statusCode);
                return response()->json(["success" => 2, "error" => "Upload failed"], 500);
            }
        }
    }
        public function deleteSelected(Request $request)
        {
            $ids = $request->input('ids');

            try {
                Episode::whereIn('id', $ids)->delete();
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }

        
    public function Series_Season_order(Request $request){

        $input = $request->all();
        $position = $_POST['position'];

        $i=1;
        foreach($position as $k=>$v){
          $SeriesSeason = SeriesSeason::find($v);
          $SeriesSeason->order = $i;
          $SeriesSeason->save();
          $i++;
        }
        return 1;
    }

    
    public function csvepisodeslug(Request $request){

        $count = Episode::where('slug',null)->orwhere('slug','')->count();
        dd($count);
        return View::make('admin.series.csvuploadblukslug.csvuploadblukslug');

    }


    public function uploadcsvepisodeslug(Request $request){

        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // Store the uploaded file
        $path = $request->file('csv_file')->store('uploads');
        // Read the CSV file
         // Load the CSV file
         $csvData = Excel::toArray([], storage_path('app/' . $path));
         $csvData = $csvData[0]; // Since toArray returns a multidimensional array

        // dd($csvData);
         $updatedData = [];
         $notUpdatedData = [];
 
         // Process each row
         foreach ($csvData as $index => $row) {
             if ($index === 0) {
                 // Save the header row for later use
                 $header = $row;
                 continue;
             }
 
             $affectedRows = Episode::where('series_id', $row[1])
                 ->where('season_id', $row[2])
                //  ->where('status', $row[6])
                 ->update(['slug' => $row[5]]);
 
             if ($affectedRows > 0) {
                 $updatedData[] = $row;
             } else {
                 $notUpdatedData[] = $row;
             }
         }
 
         // Create CSV files
         $updatedFilePath = 'uploads/updated_data.csv';
         $notUpdatedFilePath = 'uploads/not_updated_data.csv';
 
         $this->createCsvFile($header, $updatedData, $updatedFilePath);
         $this->createCsvFile($header, $notUpdatedData, $notUpdatedFilePath);
 
         return response()->json([
             'message' => 'Episodes updated successfully',
             'updated_file' => Storage::url($updatedFilePath),
             'not_updated_file' => Storage::url($notUpdatedFilePath),
             'updated_count' => count($updatedData),
             'not_updated_count' => count($notUpdatedData)
         ]);
    }



    private function createCsvFile($header, $data, $filePath)
    {
        $handle = fopen(storage_path('app/' . $filePath), 'w');
        fputcsv($handle, $header);

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }

    public function VideoCipheCreate_Episod(Request $request)
    {
        
        $data = $request->all();
        $settings =Setting::first();
     
        $createdEpisode = Episode::create([
            'title' => $request->title,
        ]);
        if(!empty($data['ppv_price'])){
            $ppv_price = $data['ppv_price'];
            $ppv_price = null;
        }elseif(!empty($data['ppv_status']) || $settings->ppv_status == 1){
            $ppv_price = $settings->ppv_price;
            $ppv_price = null;
        }else{
            $ppv_price = null;
        }

        $id = $createdEpisode->id;
        $episodes = Episode::findOrFail($id);

        if(!empty($data['m3u8_url'])){
            $episodes->type = 'm3u8_url';
        }else if(!empty($data['mp4_url'])){
            $episodes->type = 'file';
        }else if(!empty($data['embed_video_url'])){
            $episodes->type = 'embed_video_url';
        }
        
        if($episodes->type == 'm3u8'){
            $type = 'm3u8';
        }else if($episodes->type == 'embed_video_url'){
            $type = 'embed_video_url';
        } 
        elseif($episodes->type == 'aws_m3u8'){
            $type = 'aws_m3u8';
        }elseif($episodes->type == 'm3u8_url'){
            $type = 'm3u8_url';
        } elseif($episodes->type == 'bunny_cdn'){
            $type = 'bunny_cdn';
        } else{
            $type = 'file';
        }

       $mobileimages = public_path('/uploads/mobileimages');
         $Tabletimages = public_path('/uploads/Tabletimages');
         $PCimages = public_path('/uploads/PCimages');

        if (!file_exists($mobileimages)) {
            mkdir($mobileimages, 0755, true);
        }

        if (!file_exists($Tabletimages)) {
            mkdir($Tabletimages, 0755, true);
        }

        if (!file_exists($PCimages)) {
            mkdir($PCimages, 0755, true);
        }

        $path = public_path().'/uploads/episodes/';
        $image_path = public_path().'/uploads/images/';
        
        $image = (isset($data['image'])) ? $data['image'] : '';

        $file = $image;
        if (compress_responsive_image_enable() == 1 || compress_responsive_image_enable() == 0) {

        if ($request->hasFile('image')) {

            $image = $request->file('image');

                $image_filename = 'episode_' .time() . '_image.' . $image->getClientOriginalExtension();
                $image_filename = $image_filename;

                Image::make($image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $image_filename, compress_image_resolution());
                Image::make($image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $image_filename, compress_image_resolution());
                Image::make($image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $image_filename, compress_image_resolution());
                
                $data["responsive_image"] = $image_filename;

        }else{

            $data["responsive_image"] = default_vertical_image(); 
        }

        if ($request->hasFile('player_image')) {

            $player_image = $request->file('player_image');

                $player_image_filename = 'episode_' .time() . '_player_image.' . $player_image->getClientOriginalExtension();

                Image::make($player_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $player_image_filename, compress_image_resolution());
                Image::make($player_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $player_image_filename, compress_image_resolution());
                Image::make($player_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $player_image_filename, compress_image_resolution());
                
                $data["responsive_player_image"] = default_horizontal_image();

        }else{

            $data["responsive_player_image"] = $episodes->responsive_player_image; 
        }


        
        if ($request->hasFile('tv_image')) {

            $tv_image = $request->file('tv_image');

                $tv_image_filename = 'episode_' .time() . '_tv_image.' . $tv_image->getClientOriginalExtension();

                Image::make($tv_image)->resize(568,320)->save(base_path() . '/public/uploads/mobileimages/' . $tv_image_filename, compress_image_resolution());
                Image::make($tv_image)->resize(480,853)->save(base_path() . '/public/uploads/Tabletimages/' . $tv_image_filename, compress_image_resolution());
                Image::make($tv_image)->resize(675,1200)->save(base_path() . '/public/uploads/PCimages/' . $tv_image_filename, compress_image_resolution());
                
                $data["responsive_tv_image"] = $tv_image_filename;

        }else{

            $data["responsive_tv_image"] = default_horizontal_image(); 
        }


        }else{

            $data["responsive_image"] = null;
            $data["responsive_player_image"] = null; 
            $data["responsive_tv_image"] = null; 
            
        }

            if(!empty($image)){

                 if($image != ''  && $image != null){
                    $file_old = $image_path.$image;

                    if (file_exists($file_old)){
                    unlink($file_old);
                    }
                }

                if(compress_image_enable() == 1){
            
                    $episode_filename  = time().'.'.compress_image_format();
                    $episode_image     =  'episode-'.$episode_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_image,compress_image_resolution() );
                }else{

                    $episode_filename  = time().'.'.$image->getClientOriginalExtension();
                    $episode_image     =  'episode-'.$episode_filename ;
                    Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_image );
                }  

            $data['image'] = $episode_image ;

        }else if (!empty($request->video_image_url)) {
            $data["image"] = $request->video_image_url;
        } else {

            $data['image'] = 'placeholder.jpg';
        }
        
        $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

        $player_image = $player_image;

        if($request->hasFile('player_image')){

            if($player_image != ''  && $player_image != null){
                $file_old = $image_path.$player_image;
               if (file_exists($file_old)){
                unlink($file_old);
               }
           }

           if(compress_image_enable() == 1){
                
                $episode_player_filename  = time().'.'.compress_image_format();
                $episode_player_image     =  'episode-player-'.$episode_player_filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_player_image,compress_image_resolution() );
            }else{

                $episode_player_filename  = time().'.'.$image->getClientOriginalExtension();
                $episode_player_image     =  'episode-player-'.$episode_player_filename ;
                Image::make($file)->save(base_path().'/public/uploads/images/'.$episode_player_image );
            }  

           $player_image  = $episode_player_image ;

         }else if (!empty($request->selected_image_url)) {
            $player_image  = $request->selected_image_url;
        } else {
            $player_image = "default_horizontal_image.jpg";
         }

         if($request->hasFile('tv_image')){

            $tv_image = $request->tv_image;

            if(compress_image_enable() == 1){

                $Episode_tv_filename   = 'Episode-TV-Image'.time().'.'. compress_image_format();
                Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Episode_tv_filename , compress_image_resolution() );

            }else{

                $Episode_tv_filename   = 'Episode-TV-Image'.time().'.'.$file->getClientOriginalExtension();
                Image::make($tv_image)->save(base_path().'/public/uploads/images/'.$Episode_tv_filename );
            }

            $episodes->tv_image = $Episode_tv_filename;

        }else if (!empty($request->selected_tv_image_url)) {
            $episodes->tv_image  = $request->selected_tv_image_url;
        }

        if(!empty($data['searchtags'])){
            $searchtags = $data['searchtags'];
        }else{
            $searchtags = null;
        }
        if(empty($data['active'])){
            $data['active'] = 0;
        }
        if(empty($data['views'])){
            $data['views'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        if(empty($data['skip_recap'])){
            $data['skip_recap'] = "";
        }
        if(empty($data['skip_intro'])){
            $data['skip_intro'] = "";
        }
        if(empty($data['ppv_status'])){
            $data['ppv_status'] = 0;
        }else{
        $data['ppv_status'] = 1;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

         // free_content

         if(isset($data['free_content_duration'])){
            //$str_time = $data
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['free_content_duration']);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $data['free_content_duration'] = $time_seconds;
        }

        
        // $episode_upload = (isset($data['episode_upload'])) ? $data['episode_upload'] : '';

        // if($episode_upload != '' && $request->hasFile('episode_upload')) {

        //     $ffprobe = \FFMpeg\FFProbe::create();
        //     $disk = 'public';
        //     $data['duration'] = $ffprobe->streams($request->episode_upload)
        //     ->videos()
        //     ->first()                  
        //     ->get('duration'); 

        //     $rand = Str::random(16);
        //     $path = $rand . '.' . $request->episode_upload->getClientOriginalExtension();
        //     $request->episode_upload->storeAs('public', $path);
        //     $data['path'] = $rand;

        //     $thumb_path = 'public';
        //     $this->build_video_thumbnail($request->episode_upload,$path, $rand);

        //     $data['mp4_url'] = URL::to('/').'/storage/app/public/'.$path;
        //     $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
        //     $midBitrateFormat  =(new X264('libmp3lame', 'libx264'))->setKiloBitrate(1500);
        //     $highBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(3000);
        //     $converted_name = ConvertVideoForStreaming::handle($path);

        //     ConvertVideoForStreaming::dispatch($path);
        // }
            //   $episode = Episode::create($data);
            // dd($data['title']);
            if(!empty($data['title'])){
                // dd($data['global_ppv']);
                $episodes->title = $data['title'];
                }else{
                }  
                if(empty($data['active'])){
                    $active = 0;
                }else{
                    $active =$data['active'];
                }

                if(empty($data['banner'])){
                    $banner = 0;
                }else{
                    $banner = 1;
                }

                if( $request->slug == ''){

                    $slug = Episode::where('slug',$data['title'])->first();

                    $episode_slug = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $data['title'])  :  preg_replace("![^a-z0-9]+!i", "-",  $data['title'].'-'.$id )  ;
                }else{
        
                    $slug = Episode::where('slug',$request->slug)->first();
        
                    $episode_slug = $slug == null ?  preg_replace("![^a-z0-9]+!i", "-",  $data['slug'])  :  preg_replace("![^a-z0-9]+!i", "-",  $data['slug'].'-'.$id )  ;
                }

            $episodes->rating =  $data['rating'];
            $episodes->slug = $episode_slug ;
            $episodes->episode_description =  $data['episode_description'];
            $episodes->type =  $type;
            $episodes->banner =  $banner;

            // $episodes->age_restrict =  $data['age_restrict'];
            $episodes->duration =  $data['duration'];
            $episodes->access =  (!empty($data['access']) ? $data['access'] : null );
            $episodes->active =  $active;
            $episodes->search_tags =  $searchtags;
            $episodes->player_image =  $player_image;
            $episodes->series_id =  $data['series_id'];
            $episodes->season_id =  $data['season_id'];
            $episodes->image =  $data['image'];
            $episodes->skip_recap =  $data['skip_recap'];
            $episodes->recap_start_time =  $data['recap_start_time'];
            $episodes->recap_end_time =  $data['recap_end_time'];
            $episodes->skip_intro =  $data['skip_intro'];
            $episodes->intro_start_time =  $data['intro_start_time'];
            $episodes->intro_end_time =  $data['intro_end_time'];
            $episodes->ppv_price =  $ppv_price;
            $episodes->ppv_status =  $data['ppv_status'];
            $episodes->responsive_image =  $data['responsive_image'];
            $episodes->responsive_player_image =  $data['responsive_player_image'];
            $episodes->responsive_tv_image =  $data['responsive_tv_image'];
            $episodes->episode_id_480p =  !empty($data['episode_id_480p']) ? $data['episode_id_480p'] : null;
            $episodes->episode_id_720p =  !empty($data['episode_id_720p']) ? $data['episode_id_720p'] : null;
            $episodes->episode_id_1080p =  !empty($data['episode_id_1080p']) ? $data['episode_id_1080p'] : null;
            $episodes->url =  !empty($data['m3u8_url']) ? $data['m3u8_url'] : null;
            $episodes->mp4_url =  !empty($data['mp4_url']) ? $data['mp4_url'] : null;
            $episodes->embed_video_url =  !empty($data['embed_video_url']) ? $data['embed_video_url'] : null;
            $episodes->status =  1;
            
            // {{-- Ads Video.Js Player--}}

            if( admin_ads_pre_post_position() == 1){
                
                $episodes->pre_post_ads =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
                $episodes->post_ads     =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
                $episodes->pre_ads      =  (!empty($data['pre_post_ads']) ? $data['pre_post_ads'] : null );
            }
            else{
                
                $episodes->pre_ads      =  (!empty($data['pre_ads']) ? $data['pre_ads'] : null );
                $episodes->post_ads     =  (!empty($data['post_ads']) ? $data['post_ads'] : null );
                $episodes->pre_post_ads =  null ;
            }

            $episodes->mid_ads  =  (!empty($data['mid_ads']) ? $data['mid_ads'] : null );
            $episodes->video_js_mid_advertisement_sequence_time   =  (!empty($data['video_js_mid_advertisement_sequence_time']) ? $data['video_js_mid_advertisement_sequence_time'] : null );
            

            $episodes->save();

            $shortcodes = $request["short_code"];
            $languages = $request["sub_language"];
            $subtitles = isset($data["subtitle_upload"])? $data["subtitle_upload"] : "";
            // if (!empty($subtitles != "" && $subtitles != null)) {
            //     foreach ($subtitles as $key => $val) {
            //         if (!empty($subtitles[$key])) {
            //             $destinationPath = "public/uploads/subtitles/";
            //             $filename = $episodes->id . "-" . $shortcodes[$key] . ".srt";
            //             $subtitles[$key]->move($destinationPath, $filename);
            //             $subtitle_data["sub_language"] =
            //                 $languages[
            //                     $key
            //                 ]; /*URL::to('/').$destinationPath.$filename; */
            //             $subtitle_data["shortcode"] = $shortcodes[$key];
            //             $subtitle_data["episode_id"] = $id;
            //             $subtitle_data["url"] =
            //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
            //             $episode_subtitle = new SeriesSubtitle();
            //             $episode_subtitle->episode_id = $episodes->id;
            //             $episode_subtitle->shortcode = $shortcodes[$key];
            //             $episode_subtitle->sub_language = $languages[$key];
            //             $episode_subtitle->url =
            //                 URL::to("/") . "/public/uploads/subtitles/" . $filename;
            //             $episode_subtitle->save();
            //         }
            //     }
            // }

            // if (!empty($subtitles != "" && $subtitles != null)) {
            //     foreach ($subtitles as $key => $val) {
            //         if (!empty($subtitles[$key])) {
            //             $destinationPath = "public/uploads/subtitles/";
            //             $filename = $episodes->id . "-episode-" . $shortcodes[$key] . ".srt";
                        
            //             // Move uploaded file to destination path
            //             move_uploaded_file($val->getPathname(), $destinationPath . $filename);
                        
            //             // Read contents of the uploaded file
            //             $contents = file_get_contents($destinationPath . $filename);
                        
            //             // Convert time format and add line numbers
            //             $lineNumber = 0;
            //             $convertedContents = preg_replace_callback(
            //                 '/(\d{2}):(\d{2}):(\d{2})[,.](\d{3}) --> (\d{2}):(\d{2}):(\d{2})[,.](\d{3})/',
            //                 function ($matches) use (&$lineNumber) {
            //                     $lineNumber++;
            //                     return "{$lineNumber}\n{$matches[1]}:{$matches[2]}:{$matches[3]},{$matches[4]} --> {$matches[5]}:{$matches[6]}:{$matches[7]},{$matches[8]}";
            //                 },
            //                 $contents
            //             );
                        
            //             // Store converted contents to a new file
            //             $newDestinationPath = "public/uploads/convertedsubtitles/";
            //             if (!file_exists($newDestinationPath)) {
            //                 mkdir($newDestinationPath, 0755, true);
            //             }
            //             file_put_contents($newDestinationPath . $filename, $convertedContents);
                        
            //             // Save subtitle data to database
            //             $subtitle_data = [
            //                 "episode_id" => $episodes->id,
            //                 "shortcode" => $shortcodes[$key],
            //                 "sub_language" => $languages[$key],
            //                 "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
            //                 "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
            //         ];
            //             $episode_subtitle = SeriesSubtitle::create($subtitle_data);
            //         }
            //     }
            // }

                        // Define the convertTimeFormat function globally
                        function convertTimeFormat($hours, $minutes, $milliseconds) {
                            $totalSeconds = $hours * 3600 + $minutes * 60 + $milliseconds / 1000;
                            $formattedTime = gmdate("H:i:s", $totalSeconds);
                            $formattedMilliseconds = str_pad($milliseconds, 3, '0', STR_PAD_LEFT);
                            return "{$formattedTime},{$formattedMilliseconds}";
                        }
            
                        if (!empty($subtitles != "" && $subtitles != null)) {
                            foreach ($subtitles as $key => $val) {
                                if (!empty($subtitles[$key])) {
                                    $destinationPath = "public/uploads/subtitles/";
            
                                    if (!file_exists($destinationPath)) {
                                        mkdir($destinationPath, 0755, true);
                                    }
            
                                    $filename = $episodes->id . "-episode-" . $shortcodes[$key] . ".srt";
            
                                    SeriesSubtitle::where('episode_id', $episodes->id)->where('shortcode', $shortcodes[$key])->delete();
            
                                    // Move uploaded file to destination path
                                    move_uploaded_file($val->getPathname(), $destinationPath . $filename);
            
                                    // Read contents of the uploaded file
                                    $contents = file_get_contents($destinationPath . $filename);
            
                                    // Convert time format and add line numbers
                                    $lineNumber = 0;
                                    $convertedContents = preg_replace_callback(
                                        '/(\d{2}):(\d{2})\.(\d{3}) --> (\d{2}):(\d{2})\.(\d{3})/',
                                        function ($matches) use (&$lineNumber) {
                                            // Increment line number for each match
                                            $lineNumber++;
                                            // Convert time format and return with the line number
                                            return "{$lineNumber}\n" . convertTimeFormat($matches[1], $matches[2], $matches[3]) . " --> " . convertTimeFormat($matches[4], $matches[5], $matches[6]);
                                        },
                                        $contents
                                    );
            
                                    // Store converted contents to a new file
                                    $newDestinationPath = "public/uploads/convertedsubtitles/";
                                    if (!file_exists($newDestinationPath)) {
                                        mkdir($newDestinationPath, 0755, true);
                                    }
                                    file_put_contents($newDestinationPath . $filename, $convertedContents);
            
                                    // Save subtitle data to database
                                    $subtitle_data = [
                                        "episode_id" => $episodes->id,
                                        "shortcode" => $shortcodes[$key],
                                        "sub_language" => $languages[$key],
                                        "url" => URL::to("/") . "/public/uploads/subtitles/" . $filename,
                                        "Converted_Url" => URL::to("/") . "/public/uploads/convertedsubtitles/" . $filename
                                    ];
                                    $episode_subtitle = SeriesSubtitle::create($subtitle_data);
                                }
                            }
                        }

        return Redirect::to('admin/season/edit/'.$data['series_id'].'/'.$data['season_id'])->with(array('note' => 'New Episode Successfully Added!', 'note_type' => 'success') );
    }



    
    public function UploadEpisodeFlussonicStorage($storage_settings,$FlussonicUploadlibraryID,$mp4_url,$season_id,$data)
    {

        $FileName = str_replace(' ', '-', $mp4_url->getClientOriginalName());
        if($this->Enable_Flussonic_Upload == 1){
       
            try {
                $client = new \GuzzleHttp\Client();

                $response = $client->request('PUT', "{$this->Flussonic_Server_Base_URL}streamer/api/v3/vods/{$this->Flussonic_Storage_Tag}/storages/{$FlussonicUploadlibraryID}/files/{$FileName}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->Flussonic_Auth_Key, 
                    'Content-Type' => 'application/json', 
                ],
                'body' => fopen($mp4_url, 'r'), 
            ]);
        
            $responseData = json_decode($response->getBody(), true);
                
            $url = "{$this->Flussonic_Server_Base_URL}{$responseData['name']}/index.m3u8";
            $videoUrl = str_replace('http://', 'https://', $url);

            $series_id = $data['series_id'];
            $season_id = $data['season_id'];
                
            $Episode = new Episode();
            $Episode->disk = "public";
            $Episode->title = $FileName;
            $Episode->series_id = $series_id;
            $Episode->season_id = $season_id;
            $Episode->url = $videoUrl;
            $Episode->type = "m3u8_url";
            $Episode->active = 1;
            $Episode->image = default_vertical_image();
            $Episode->tv_image = default_horizontal_image();
            $Episode->player_image = default_horizontal_image();
            $Episode->user_id = Auth::user()->id;
            $Episode->episode_order = Episode::where('season_id',$season_id)->max('episode_order') + 1 ;
            $Episode->save();

            $Episode_id = $Episode->id;


            if(Enable_Extract_Image() == 1){
                // extractImageFromVideo
                
                $rand = Str::random(16);
            
                $ffmpeg = \FFMpeg\FFMpeg::create();
                $videoFrame = $ffmpeg->open($mp4_url);
                
                // Define the dimensions for the frame (16:9 aspect ratio)
                $frameWidth = 1280;
                $frameHeight = 720;
                
                // Define the dimensions for the frame (9:16 aspect ratio)
                $frameWidthPortrait = 1080;  // Set the desired width of the frame
                $frameHeightPortrait = 1920; // Calculate height to maintain 9:16 aspect ratio
                
                $randportrait = 'portrait_' . $rand;
                
                $interval = 5; // Interval for extracting frames in seconds
                $totalDuration = round($videoFrame->getStreams()->videos()->first()->get('duration'));
                $totalDuration = intval($totalDuration);


                if ( 600 < $totalDuration) { 
                    $timecodes = [5, 120, 240, 360, 480]; 
                } else { 
                    $timecodes = [5, 10, 15, 20, 25]; 
                }

                
                foreach ($timecodes as $index => $time) {
                    $imagePortraitPath = public_path("uploads/images/{$Episode_id}_{$randportrait}_{$index}.jpg");
                    $imagePath = public_path("uploads/images/{$Episode_id}_{$rand}_{$index}.jpg");
            
                    try {
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidth, $frameHeight));
            
                        $videoFrame
                            ->frame(TimeCode::fromSeconds($time))
                            ->save($imagePortraitPath, new X264('libmp3lame', 'libx264'), null, new Dimension($frameWidthPortrait, $frameHeightPortrait));
            
                        $VideoExtractedImage = new VideoExtractedImages();
                        $VideoExtractedImage->user_id = Auth::user()->id;
                        $VideoExtractedImage->socure_type = 'Episode';
                        $VideoExtractedImage->video_id = $Episode_id;
                        $VideoExtractedImage->image_original_name = $Episode_id;
                        $VideoExtractedImage->image_path = URL::to("/public/uploads/images/" . $Episode_id . '_' . $rand . '_' . $index . '.jpg');
                        $VideoExtractedImage->portrait_image = URL::to("/public/uploads/images/" . $Episode_id . '_' . $randportrait . '_' . $index . '.jpg');
                        $VideoExtractedImage->image_original_name = $Episode_id . '_' . $rand . '_' . $index . '.jpg';
                        $VideoExtractedImage->save();

                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            
            }


            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["Episode_id"] = $Episode_id;
    

            return $value ;
   

            } catch (RequestException $e) {
                $value["success"] = 2;
                \LogActivity::addVideoLog("Failed Flussonic VIDEO Upload.", $video_id);
                return $value ;
            }
        }else{
            $value["success"] = 2;
            \LogActivity::addVideoLog("Failed Flussonic VIDEO Upload.", $video_id);
            return $value ;
        }

    }


    
    public function Flussonicepisodelibrary(Request $request)
    {

        if($this->Enable_Flussonic_Upload == 1){
       
            try {
                $client = new \GuzzleHttp\Client();
                // http://localhost:8080/streamer/api/v3/vods/{prefix}/storages/{storage_index}/files

                
                $response = $client->request('GET', "{$this->Flussonic_Server_Base_URL}streamer/api/v3/vods/{$this->Flussonic_Storage_Tag}/storages/{$request->FlussonicepisodelibraryID}/files", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->Flussonic_Auth_Key, 
                        'Content-Type' => 'application/json', 
                    ]
                ]);
              
        
            $response = json_decode($response->getBody(), true);
            $url = "{$this->Flussonic_Server_Base_URL}";
            $StreamURL = str_replace('http://', 'https://', $url);

            $responseData = [
                'streamvideos' => $response,
                'StreamURL' => $StreamURL,
            ];
        
            return $responseData;

        }catch (RequestException $e) {
            $value["success"] = 2;
            // echo"<pre>";
            // print_r($e->getMessage());exit;
            \LogActivity::addVideoLog("Failed Flussonic VIDEO Upload.", $video_id);
            return $value ;
        }
    }
}



    
    public function StreamFlussonicEpisode(Request $request)
    {
        $data = $request->all();
        $value = [];

        if (!empty($data["stream_flussonic_episode"])) {

            $Episode = new Episode();
            $Episode->disk = "public";
            $Episode->title = $data["stream_flussonic_episode"];
            $Episode->url = $data["stream_flussonic_episode"];
            $Episode->series_id = $data["series_id"];
            $Episode->season_id = $data["season_id"];
            $Episode->type = "m3u8_url";
            $Episode->active = 1;
            $Episode->episode_order = Episode::where('season_id',$data["season_id"])->max('episode_order') + 1 ;
            $Episode->image = default_vertical_image();
            $Episode->tv_image = default_horizontal_image();
            $Episode->player_image = default_horizontal_image();
            $Episode->user_id = Auth::user()->id;
            $Episode->save();

            $Episode_id = $Episode->id;

            $value["success"] = 1;
            $value["message"] = "Uploaded Successfully!";
            $value["Episode_id"] = $Episode_id;

            return $value;
        }
    }

    function get_processed_percentage_episode($id)
    {
        return Episode::where("id", "=", $id)->first();
    }

    public function UnassignedEpisodes(Request $request)
    {
        // dd($request);
       
        foreach ($request['episodes'] as $episode) {
            $updated = Episode::where('id', $episode['id'])->update(['season_id' => !empty($episode['season_id']) ? ($episode['season_id']) : Null ]);
        }
        return redirect()->back()->with('success', 'Episodes updated successfully.');
    }



}
