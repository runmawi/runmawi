<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seriesartist extends Model
{
    protected $table = 'series_artists';
	protected $guarded = array();
	public static $rules = array();
	public $timestamps = false;

	protected $fillable = array('series_id','artist_id');
}
