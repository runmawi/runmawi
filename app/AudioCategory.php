<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioCategory extends Model
{
    protected $guarded = array();

    protected $table = 'audio_categories';

    public static $rules = array();

    public function audios(){
        return $this->hasMany('Audio');
    }

    public function hasChildren(){
        if(DB::table('audio_categories')->where('parent_id', '=', $this->id)->count() >= 1){
            return true;
        } else {
            return false;
        }
    }

     public function childs() {

        return $this->hasMany('App\AudioCategory','parent_id','id') ;

    }

    public function specific_category_audio()
    {
        return $this->belongsToMany('App\Audio', 'category_audios','category_id','audio_id');
    }

    public function category_audios()
    {
        return $this->belongsToMany('App\Audio','category_audios','category_id','audio_id');
    }
}
