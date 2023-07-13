<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminVideoPlaylist extends Model
{
    protected $guarded = array();

    protected $table = 'admin_video_playlist';
    
    public static $rules = array();

}
