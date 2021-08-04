<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioAlbums  extends Model {
    protected $guarded = array();

    protected $table = 'audio_albums';

    public static $rules = array();

    public function audios(){
        return $this->hasMany('Audio');
    }

    public function hasChildren(){
        if(DB::table('audio_albums')->count() >= 1){
            return true;
        } else {
            return false;
        }
    }

     public function childs() {

        return $this->hasMany('App\AudioAlbums','parent_id','id') ;

    }
}