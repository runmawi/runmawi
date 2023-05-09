<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class SeriesSubtitle extends Model
{
    protected $guarded = array();

	protected $table = 'series_subtitles';
	
	public static $rules = array();

}
