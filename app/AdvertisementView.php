<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisementView extends Model
{
    protected $table = 'ads_details_views';

    protected $fillable = array('user_id','video_id','ads_id','created_at','updated_at');
}
