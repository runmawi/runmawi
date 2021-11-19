<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsVideo extends Model
{
    protected $table = 'ads_videos';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('video_id','ads_id','ad_roll');
}
