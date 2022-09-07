<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class VideoSchedules extends Model
{
    protected $guarded = array();

	protected $table = 'video_schedules';
	
	public static $rules = array();


}
