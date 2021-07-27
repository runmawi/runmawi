<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Series as Series;
use \App\User as User;
use \App\Genre as Genre;
use App\Episode as Episode;
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
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Seriesartist;

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

    /**
     * Show the form for creating a new series
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Series',
            'post_route' => URL::to('admin/series/store'),
            'button_text' => 'Add New Series',
            'admin_user' => Auth::user(),
            'series_categories' => VideoCategory::all(),
            'languages' => Language::all(),
            'artists' => Artist::all(),
            'series_artist' => [],
            );
        return View::make('admin.series.create_edit', $data);
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
            
        
//        if ($validatedData->fails())
//        {
//            return Redirect::back()->withErrors($validator)->withInput();
//        }
        
         /*Slug*/
        $data = $request->all();
        
       if(!empty($data['artists'])){
            $artistsdata = $data['artists'];
            unset($data['artists']);
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
                  $data['image']  = $file->getClientOriginalName();
                  $file->move($image_path, $data['image']);

            } else {
                $data['image'] = 'placeholder.jpg';
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
        
        if(!empty($artistsdata)){
            foreach ($artistsdata as $key => $value) {
                $artist = new Seriesartist;
                $artist->series_id =  $series->id;
                $artist->artist_id = $value;
                $artist->save();
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
            //$episode = Episode::all();
            $seasons = SeriesSeason::where('series_id','=',$id)->with('episodes')->get();
            // $books = SeriesSeason::with('episodes')->get();
//
//                    print_r(count($seasons));
//                    exit;
                    
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Series',
            'series' => $series,
            'seasons' => $seasons,
            'post_route' => URL::to('admin/series/update'),
            'button_text' => 'Update Series',
            'admin_user' => Auth::user(),
            'series_categories' => Genre::all(),
            'languages' => Language::all(),
            'artists' => Artist::all(),
            'series_artist' => Seriesartist::where('series_id', $id)->pluck('artist_id')->toArray(),
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
                  $data['image']  = $file->getClientOriginalName();
                  $file->move($image_path, $data['image']);

            } else {
                $data['image'] = 'placeholder.jpg';
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

                $update_url->save();  


     
        }

        
        
        
        $series->update($data);
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

    public function create_season($id)
    {
        $data['series_id'] = $id; 
        $series = SeriesSeason::create($data);
        return Redirect::to('admin/series/edit' . '/' . $id)->with(array('note' => 'Successfully Created Season!', 'note_type' => 'success') );
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
        $episodes = Episode::where('series_id' ,'=', $series_id)->where('season_id' ,'=', $season_id)->get();
        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Manage episodes of Season '.$season_id.' : '.$series->title,
            'episodes' => $episodes,
            'series' => $series,
            'season_id' => $season_id,
            'post_route' => URL::to('admin/episode/create'),
            'button_text' => 'Create Episode',
            'admin_user' => Auth::user(),
            );

        return View::make('admin.series.season_edit', $data);

    }

    public function create_episode(Request $request)
    {
       

       // $validator = Validator::make($data = $request->all(), Episode::$rules);
        
        $data = $request->all();

        //        if ($validator->fails())
        //        {
        //            return Redirect::back()->withErrors($validator)->withInput();
        //        }
        
         /*Slug*/
//        if ($request->slug != '') {
//            $data['slug'] = $this->createSlug($request->slug);
//        }
//
//        if($request->slug == ''){
//            $data['slug'] = $this->createSlug($data['title']);    
//        }
        
        
        
    //          $validatedData = $request->validate([
    //                'title' => 'required',
    //                'description' => 'required',
    //                'details' => 'required',
    //                'episode_upload' => 'required',
    //                'year' => 'required',
    //                'image' => 'required'
    //            ]);
    //        
        
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
              $data['image']  = $file->getClientOriginalName();
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

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

       

       // $resolution_data['episode_id'] = $episode->id;
        
         //= $request->file('episode_upload');
        
        $episode_upload = (isset($data['episode_upload'])) ? $data['episode_upload'] : '';

        if($episode_upload != '') {
            if($episode_upload != ''  && $episode_upload != null){
                   $file_old = $path.$episode_upload;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $episode_upload;
              $trailer_vid  = $file->getClientOriginalName();
              $file->move($path, $trailer_vid);
            
              $data['mp4_url']  = URL::to('/').'/public/uploads/episodes/'.$file->getClientOriginalName();
        }
              $episode = Episode::create($data);
       
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
            );

        return View::make('admin.series.edit_episode', $data);
    }

    public function update_episode(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $episode = Episode::findOrFail($id);

        $data = $request->all();

//        if ($validator->fails())
//        {
//            return Redirect::back()->withErrors($validator)->withInput();
//        }
        /*Slug*/
//        if ($episode->slug != $request->slug) {
//            $data['slug'] = $this->createSlugEpisode($request->slug, $id);
//        }
//
//        if($request->slug == '' || $episode->slug == ''){
//            $data['slug'] = $this->createSlugEpisode($data['title']);    
//        }
        
          
        $path = public_path().'/uploads/episodes/';
        $image_path = public_path().'/uploads/images/';
        
        
        
        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

//        if(empty($data['image'])){
//            unset($data['image']);
//        } else {
//            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
//        }
        
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
              $data['image']  = $file->getClientOriginalName();
              $file->move($image_path, $data['image']);
            } else {
                $data['image'] = 'placeholder.jpg';
            }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
        
          $episode_upload = (isset($data['episode_upload'])) ? $data['episode_upload'] : '';

        if($episode_upload != '') {
            if($episode_upload != ''  && $episode_upload != null){
                   $file_old = $path.$episode_upload;
                  if (file_exists($file_old)){
                   unlink($file_old);
                  }
              }
              //upload new file
              $file = $episode_upload;
              $trailer_vid  = $file->getClientOriginalName();
              $file->move($path, $trailer_vid);
            
              $data['mp4_url']  = URL::to('/').'/public/uploads/episodes/'.$file->getClientOriginalName();
        }
        
        
        $episode->update($data);


        $episode = Episode::findOrFail($id);
        return Redirect::to('admin/season/edit' . '/' . $episode->series_id .'/'.$episode->season_id)->with(array('note' => 'Successfully Updated Episode!', 'note_type' => 'success') );
    
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
}
