<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoPlaylist extends Model
{
    protected $guarded = array();

    protected $table = 'video_playlist';
    
    public static $rules = array();

}
