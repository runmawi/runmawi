<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class VideoEvents extends Model
{
    protected $guarded = array();

	protected $table = 'video_events';
	
	public static $rules = array();



}
