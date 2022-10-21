<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReSchedule extends Model
{
    protected $table = 'video_reschedule';
    protected $guarded = array();
    public static $rules = array();

}
