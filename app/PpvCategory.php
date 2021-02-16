<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpvCategory extends Model
{
        protected $guarded = array();

        protected $table = 'ppv_categories';

        public static $rules = array();

        public function videos(){
            return $this->hasMany('Video');
        }

        public function hasChildren(){
            if(DB::table('ppv_categories')->where('parent_id', '=', $this->id)->count() >= 1){
                return true;
            } else {
                return false;
            }
        }

         public function childs() {

            return $this->hasMany('App\PpvCategory','parent_id','id') ;

        }
    
   
        public function subcategory(){

            return $this->hasMany('App\PpvCategory', 'parent_id');

        }
}
