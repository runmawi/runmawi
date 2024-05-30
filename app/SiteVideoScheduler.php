<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteVideoScheduler extends Model
{
    protected $table = 'site_videos_scheduler';

    protected $guarded = array();

    public static $rules = array();

}
