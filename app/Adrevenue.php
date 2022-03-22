<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adrevenue extends Model
{
    protected $table = 'ads_revenue';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('video_id','ad_id','advertiser_id','advertiser_share','admin_share');
}
