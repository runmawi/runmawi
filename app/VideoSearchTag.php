<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class VideoSearchTag extends Model
{
    protected $guarded = array();

	protected $table = 'video_tags';
	
	public static $rules = array();



}
