<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveCategory extends Model
{
        protected $guarded = array();

        protected $table = 'live_categories';

        public static $rules = array();

        public function videos(){
            return $this->hasMany('LiveStream');
        }

        public function hasChildren(){
            if(DB::table('live_categories')->where('parent_id', '=', $this->id)->count() >= 1){
                return true;
            } else {
                return false;
            }
        }

         public function childs() {

            return $this->hasMany('App\LiveCategory','parent_id','id') ;

        }
    
   
        public function subcategory(){

            return $this->hasMany('App\LiveCategory', 'parent_id');

        }
}
