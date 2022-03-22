<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adviews extends Model
{
    protected $table = 'ads_views';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('video_id','ad_id','advertiser_id','views_count');
}
