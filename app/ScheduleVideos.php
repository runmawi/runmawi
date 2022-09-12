<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleVideos extends Model
{
    protected $table = 'schedule_videos';
    protected $guarded = array();
    public static $rules = array();

}
