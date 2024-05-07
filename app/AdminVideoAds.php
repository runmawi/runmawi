<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminVideoAds extends Model
{
    protected $guarded = array();

    protected $table = 'admin_video_ads';
    
    public static $rules = array();
}
