<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\ConvertEpisodeVideo;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Seriesartist;
use GifCreator\GifCreator;
use FFMpeg\Coordinate\TimeCode;
use File;
use App\SeriesCategory as SeriesCategory;
use App\SeriesLanguage as SeriesLanguage;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\SeriesGenre;
use App\Jobs\ConvertSerieTrailer;
use Streaming\Representation;
use getID3;
use App\InappPurchase;

class AdminSeriesController extends Controller
{
     /**
     * Display a listing of series
     *
     * @return Response
     */
    public function index(Request $request)
    {
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
            }else{

          $search_value = $request->get('s');
        
            if(!empty($search_value)):
                $series = Series::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
            else:
                $series = Series::orderBy('created_at', 'DESC')->paginate(9);
            endif;
        
       // $series = Series::orderBy('created_at', 'DESC')->paginate(9);
       
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
        }else{
        $data = array(
            'settings ' => $settings,
            'headline' => '<i class="fa fa-plus-circle"></i> New Series',
            'post_route' => URL::to('admin/series/store'),
            'button_text' => 'Add New Series',
            'admin_user' => Auth::user(),
            'series_categories' => VideoCategory::all(),
            'languages' => Language::all(),
            'artists' => Artist::all(),
            'series_artist' => [],
            'category_id' => [],
            'languages_id' => [],
            'InappPurchase' => InappPurchase::all(),
            
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
       if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
        }

        if(!empty($data['genre_id'])){
            $genre_iddata = $data['genre_id'];
            unset($data['genre_id']);
        }
        if ($request->slug != '') {
            $slug = str_replace(' ', '_', $request->slug);
            $data['slug'] =$slug;
            }
        if($request->slug == ''){
            $slug = str_replace(' ', '_', $request->title);
            $data['slug'] =$slug;
        }
        if(!empty($data['language'])){
            $languagedata = $data['language'];
            unset($data['language']);
        }
                 $path = public_path().'/uploads/videos/';
                 $image_path = public_path().'/uploads/images/';
        
            $image = (isset($data['image'])) ? $data['image'] : '';
            if(!empty($image)){
                //$data['image'] = ImageHandler::uploadImage($data['image'], 'images');
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
        
            $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

            if(!empty($player_image) && $data['player_image'] != 'validate'){
                //$data['image'] = ImageHandler::uploadImage($data['image'], 'images');
                if($player_image != ''  && $player_image != null){
                       $file_old = $image_path.$player_image;
                      if (file_exists($file_old)){
                       unlink($file_old);
                      }
                  }
                  //upload new file
                  $player_image = $player_image;
                 //  $data['player_image']  = $player_image->getClientOriginalName();
                 $data['player_image'] =  str_replace(' ', '_', $player_image->getClientOriginalName());

                  $player_image->move($image_path, $data['player_image']);
                 //  $player_image =  $player_image->getClientOriginalName();
            $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());



            } else {
             $player_image = "default_horizontal_image.jpg";
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

        $series = Series::create($data);
        // dd($series->id);
        if(!empty($data['ppv_status'])){

            $ppv_status = $data['ppv_status'];
        }else{
            $ppv_status = 0;
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

        $series->slug =  $slug;
        $series = Series::find($series->id);
        $series->slug = $slug;
        $series->ppv_status = $ppv_status;
        $series->player_image = $player_image;
        $series->banner = empty($data['banner']) ? 0 : 1;
        $series->search_tag =$data['search_tag'];
        $series->details =strip_tags($data['details']);
        $series->season_trailer = $season_trailer ;
        $series->series_trailer = $series_trailer ;
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

            //$episode = Episode::all();
            $seasons = SeriesSeason::where('series_id','=',$id)->with('episodes')->get();
            // $books = SeriesSeason::with('episodes')->get();   
                    // dd(SeriesLanguage::where('series_id', $id)->pluck('language_id')->toArray());
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Series',
            'series' => $series,
            'settings' => $settings,
            'seasons' => $seasons,
            'post_route' => URL::to('admin/series/update'),
            'button_text' => 'Update Series',
            'admin_user' => Auth::user(),
            'series_categories' => VideoCategory::all(),
            'languages' => Language::all(),
            'artists' => Artist::all(),
            'series_artist' => Seriesartist::where('series_id', $id)->pluck('artist_id')->toArray(),
            'category_id' => SeriesCategory::where('series_id', $id)->pluck('category_id')->toArray(),
            'languages_id' => SeriesLanguage::where('series_id', $id)->pluck('language_id')->toArray(),
            'InappPurchase' => InappPurchase::all(),
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
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }
        if ($request->slug != '') {
            $slug = str_replace(' ', '_', $request->slug);
            $data['slug'] =$slug;
            }else{
                $data['slug'] =$request->slug; 
            }
        if($request->slug == ''){
            $slug = str_replace(' ', '_', $request->title);
            $data['slug'] =$slug; 
        }else{
            $data['slug'] =$request->slug; 
        }

         $path = public_path().'/uploads/videos/';
         $image_path = public_path().'/uploads/images/';
        
            $image = (isset($data['image'])) ? $data['image'] : '';
            if(!empty($image)){
                //$data['image'] = ImageHandler::uploadImage($data['image'], 'images');
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
                $data['image'] = $series->image;
            }

            $path = public_path().'/uploads/videos/';
            $image_path = public_path().'/uploads/images/';
               $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

               if(!empty($player_image) && $data['player_image'] != 'validate'){
                   //$data['image'] = ImageHandler::uploadImage($data['image'], 'images');
                   if($player_image != ''  && $player_image != null){
                          $file_old = $image_path.$player_image;
                         if (file_exists($file_old)){
                          unlink($file_old);
                         }
                     }
                     //upload new file
                     $player_image = $player_image;
                    //  $data['player_image']  = $player_image->getClientOriginalName();
                    $data['player_image'] =  str_replace(' ', '_', $player_image->getClientOriginalName());

                     $player_image->move($image_path, $data['player_image']);
                    //  $player_image =  $player_image->getClientOriginalName();
               $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());


   
               } else {
                $player_image = $series->player_image;
               }
            //    dd($player_image);
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
        $series->ppv_status = $ppv_status;
        $series->details =strip_tags($data['details']);
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
        $series = Series::find($id);
        


        //$this->deleteSeriesImages($series);

        Series::destroy($id);
        Seriesartist::where('series_id',$id)->delete();
        Episode::where('series_id',$id)->delete();

//        SeriesResolution::where('series_id', '=', $id)->delete();
//        SeriesSubtitle::where('series_id', '=', $id)->delete();

        return Redirect::to('admin/series-list')->with(array('note' => 'Successfully Deleted Series', 'note_type' => 'success') );
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

        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {
                    
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
                                $r_1080p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
                                array_push($convertresolution,$r_1080p);
                            }
                    }
                    
                }
                // dd($convertresolution);

                            $trailer = $data['trailer'];
                            $trailer_path  = URL::to('public/uploads/season_trailer/');
                            $trailer_Video =  time().'_'.$trailer->getClientOriginalName();  
                            $trailer->move(public_path('uploads/season_trailer/'), $trailer_Video);
                            $trailer_video_name = strtok($trailer_Video, '.');
                            $M3u8_save_path = $trailer_path.'/'.$trailer_video_name.'.m3u8';
                            $storepath  = URL::to('public/uploads/season_trailer/');
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

        } else {
            $data['trailer'] = '';
            $data['trailer_type']  = '';
        }

    }
    $image_path = public_path().'/uploads/season_images/';
    $path = public_path().'/uploads/season_videos/';

        if($image != '') {   
            //code for remove old file
            if($image != ''  && $image != null){
                // $file_old = $image_path.$image;
                // if (file_exists($file_old)){
                // unlink($file_old);
                // }
            }
            //upload new file
            $file = $image;
            // $data['image']  = URL::to('/').'/public/uploads/season_images/'.$file->getClientOriginalName();
            $data['image'] =  URL::to('/').'/public/uploads/season_images/'.str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($image_path, $data['image']);

        } else {
            $data['image']  = 'default.jpg';
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
        $series->save();
        
        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {
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
        // dd($season);
        $data =array(
            'season' => $season,
            'InappPurchase' => InappPurchase::all(),
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

if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {
            
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
                        $r_1080p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
                        array_push($convertresolution,$r_1080p);
                    }
            }
            
        }
        // dd($convertresolution);

                    $trailer = $data['trailer'];
                    $trailer_path  = URL::to('public/uploads/season_trailer/');
                    $trailer_Video =  time().'_'.$trailer->getClientOriginalName();  
                    $trailer->move(public_path('uploads/season_trailer/'), $trailer_Video);
                    $trailer_video_name = strtok($trailer_Video, '.');
                    $M3u8_save_path = $trailer_path.'/'.$trailer_video_name.'.m3u8';
                    $storepath  = URL::to('public/uploads/season_trailer/');

                    $data['trailer'] = $M3u8_save_path;
                    $data['trailer_type']  = 'm3u8_url';

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

        } else {
            $data['trailer'] = $series_season->trailer;
            $data['trailer_type']  = 'mp4_url';

        }
    }

        if($image != '') {   
            //code for remove old file
            if($image != ''  && $image != null){
                $file_old = $image_path.$image;
                if (file_exists($file_old)){
                unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            // $data['image']  = URL::to('/').'/public/uploads/season_images/'.$file->getClientOriginalName();
            $data['image'] =  URL::to('/').'/public/uploads/season_images/'.str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($image_path, $data['image']);

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
        if(!empty($data['ppv_interval'])){
            $ppv_interval = $data['ppv_interval'];
        }else{
            $ppv_interval = $series_season->ppv_interval;
        }
        if(!empty($data['ios_ppv_price'])){
            $ios_ppv_price = $data['ios_ppv_price'];
        }else{
            $ios_ppv_price = $series_season->ios_ppv_price;
        }
        $series_season->series_id = $series_season->series_id;
        $series_season->image = $data['image'];
        $series_season->trailer = $data['trailer'];
        $series_season->trailer_type = $data['trailer_type'];
        $series_season->access = $access;
        $series_season->ppv_price = $ppv_price;
        $series_season->ppv_interval = $ppv_interval;
        $series_season->ios_product_id = $ios_ppv_price;
        $series_season->save();

        if($trailer != '' && $pack == "Business"  && $settings->transcoding_access  == 1) {
            ConvertSerieTrailer::dispatch($series_season,$storepath,$convertresolution,$trailer_video_name,$trailer_Video);
        }

        return Redirect::back();
    
    }
    
    public function destroy_season($id)
    {
        $series_id = SeriesSeason::find($id)->series_id;

        SeriesSeason::destroy($id);

        return Redirect::to('admin/series/edit' . '/' . $id)->with(array('note' => 'Successfully Deleted Season', 'note_type' => 'success') );
    }

    public function manage_season($series_id,$season_id)
    {
        $series = Series::find($series_id);
        $episodes = Episode::where('series_id' ,'=', $series_id)
        ->where('season_id' ,'=', $season_id)->orderBy('episode_order')->get();
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Manage episodes of Season '.$season_id.' : '.$series->title,
            'episodes' => $episodes,
            'series' => $series,
            'season_id' => $season_id,
            'post_route' => URL::to('admin/episode/create'),
            'button_text' => 'Create Episode',
            'admin_user' => Auth::user(),
            'age_categories' => AgeCategory::all(),
            'settings' => Setting::first(),
            'InappPurchase' => InappPurchase::all(),


            );

        return View::make('admin.series.season_edit', $data);

    }

    public function create_episode(Request $request)
    {
        
        $data = $request->all();
        $settings =Setting::first();

        if(!empty($data['ppv_price'])){
            $ppv_price = $data['ppv_price'];
        }elseif(!empty($data['ppv_status']) || $settings->ppv_status == 1){
            $ppv_price = $settings->ppv_price;
        }else{
            $ppv_price = null;

        }
        // dd($data);

        $id = $data['episode_id'];
        $episodes = Episode::findOrFail($id);

        if($episodes->type == 'm3u8'){
            $type = 'm3u8';
        }else{
            $type = 'file';
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
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());
              $file->move($image_path, $data['image']);
        } else {
            $data['image'] = 'placeholder.jpg';
        }

        
        $player_image = (isset($data['player_image'])) ? $data['player_image'] : '';

        if($request->hasFile('player_image')){

            if($player_image != ''  && $player_image != null){
                $file_old = $image_path.$player_image;
               if (file_exists($file_old)){
                unlink($file_old);
               }
           }

           //upload new file
           $player_image = $player_image;
           $data['player_image']  = str_replace(' ', '_', $player_image->getClientOriginalName());
           $player_image->move($image_path, $data['player_image']);
        //    $player_image = $file->getClientOriginalName();
        $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());


         } else {
            // $player_image = $episode->player_image;
            $player_image = "default_horizontal_image.jpg";
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
            if ($request->slug != '') {
            $data['slug'] = $this->createSlug($request->slug);
            }
            if($request->slug == ''){
                $data['slug'] = $this->createSlug($data['title']);    
            }

            // if(empty($data['slug'])){
            //   $slug =   str_replace(' ', '_', $data['title']);
            // }else{
            //     $slug =   str_replace(' ', '_', $data['slug']);
            // }
            // $episode->title =  $data['title'];
            $episodes->rating =  $data['rating'];
            $episodes->slug =  $data['slug'];

            $episodes->type =  $type;
            $episodes->banner =  $banner;

            // $episodes->age_restrict =  $data['age_restrict'];
            $episodes->duration =  $data['duration'];
            $episodes->access =  $data['access'];
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
              $episodes->status =  1;
              $episodes->episode_order = $episode = Episode::max('episode_order') + 1 ;
              $episodes->save();


        return Redirect::to('admin/season/edit/'.$data['series_id'].'/'.$data['season_id'])->with(array('note' => 'New Episode Successfully Added!', 'note_type' => 'success') );
    }

    public function destroy_episode($id)
    {
        $series_id = Episode::find($id)->series_id;
        $season_id = Episode::find($id)->season_id;

        Episode::destroy($id);

        return Redirect::to('admin/season/edit' . '/' . $series_id.'/'.$season_id)->with(array('note' => 'Successfully Deleted Season', 'note_type' => 'success') );
    }

    public function edit_episode($id)
    {
        $episodes = Episode::find($id);
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Episode '.$episodes->title,
            'episodes' => $episodes,
            'post_route' => URL::to('admin/episode/update'),
            'button_text' => 'Update Episode',
            'admin_user' => Auth::user(),
            'age_categories' => AgeCategory::all(),
            'settings' => Setting::first(),


            );

        return View::make('admin.series.edit_episode', $data);
    }

    public function update_episode(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $episode = Episode::findOrFail($id);


        if(!empty($input['searchtags'])){
            $searchtags = $input['searchtags'];
        }else{
            $searchtags = $episode->searchtags;
        }
        if(empty($input['image']) && !empty($episode->image)){
            $image = $episode->image ;
        }else{
            // $image = $input['image'] ;
            $image = (isset($input['image'])) ? $input['image'] : '';

        }

        if(empty($input['player_image']) && !empty($episode->player_image)){
            $player_image = $episode->player_image ;
        // dd('$player_image');

        }else{
            // $player_image = $input['player_image'] ;
            $player_image = (isset($input['player_image'])) ? $input['player_image'] : '';
            // dd($player_image);

        }
       
        $settings =Setting::first();
        if(!empty($input['ppv_price'])){
            $ppv_price = $input['ppv_price'];
        }elseif(!empty($input['ppv_price']) || $settings->ppv_status == 1){
            $ppv_price = $settings->ppv_price;
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
              //upload new file
              $file = $image;
            //   $data['image']  = $file->getClientOriginalName();
            $data['image'] = str_replace(' ', '_', $file->getClientOriginalName());

              $file->move($image_path, $data['image']);
            } else {
                $data['image'] = $episode->image ;
            }


            if($request->hasFile('player_image')){

                if($player_image != ''  && $player_image != null){
                    $file_old = $image_path.$player_image;
                   if (file_exists($file_old)){
                    unlink($file_old);
                   }
               }

               //upload new file
               $player_image = $player_image;
               $data['player_image']  = str_replace(' ', '_', $player_image->getClientOriginalName());
               $player_image->move($image_path, $data['player_image']);
            //    $player_image = $file->getClientOriginalName();
            $player_image = str_replace(' ', '_', $player_image->getClientOriginalName());


             } else {
                $player_image = $episode->player_image;

             }

        // dd('$player_image');
             
        if(empty($data['active'])){
            $data['active'] = 0;
        }
        if(empty($data['slug'])){
            $slug = str_replace(' ', '_', $episode->title);
        }else{
            $slug = str_replace(' ', '_', $data['slug']);
        }
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
        }else{
            $type = $data['type'];
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
        $episode->status =  1;
        $episode->save();

        $episode = Episode::findOrFail($id);
        return Redirect::to('admin/season/edit' . '/' . $episode->series_id .'/'.$episode->season_id)->with(array('note' => 'Successfully Updated Episode!', 'note_type' => 'success') );
    
    }

    public function EpisodeUpload(Request $request){

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
         $episode->save(); 
         $episode_id = $episode->id;
        $episode_title = Episode::find($episode_id);
        $title =$episode_title->title; 
        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['episode_id'] = $episode_id;
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
        $video->duration = $Video_duration;
         $video->save();

         ConvertEpisodeVideo::dispatch($video,$storepath);

         $episode_id = $video->id;
        $episode_title = Episode::find($episode_id);
        $title =$episode_title->title; 
        $value['success'] = 1;
        $value['message'] = 'Uploaded Successfully!';
        $value['episode_id'] = $episode_id;
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





    public function createSlug($title, $id = 0)
    {
        // Normalize the title
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
        return 1;

    }

}
