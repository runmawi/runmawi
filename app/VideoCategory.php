<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Video;

class VideoCategory extends Model
{
        protected $guarded = array();

        protected $table = 'video_categories';

        public static $rules = array();

        public function videos(){
            return $this->hasMany('Video');
        }

        public function hasChildren(){
            if(DB::table('video_categories')->where('parent_id', '=', $this->id)->count() >= 1){
                return true;
            } else {
                return false;
            }
        }

         public function childs() {

            return $this->hasMany('App\VideoCategory','parent_id','id') ;

        }
    
   
        public function subcategory(){

            return $this->hasMany('App\VideoCategory', 'parent_id');

        }
    
        public function channelVideo(){

                return $this->hasMany('App\Video', 'id');
        }
        public function VideoCategory()
        {
            return $this->belongsTo('App\VideoCategory');
        }

        public function specific_category_series()
        {
            return $this->belongsToMany(Series::class, 'series_categories','category_id','series_id');
        }

        public function specific_category_videos()
        {
            return $this->belongsToMany('App\Video', 'categoryvideos','category_id','video_id');
        }

        public function category_videos()
        {
            return $this->belongsToMany( 'App\Video','categoryvideos','category_id','video_id');
        }
}