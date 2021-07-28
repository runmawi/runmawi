<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videoartist extends Model
{
    protected $table = 'video_artists';
	protected $guarded = array();
	public static $rules = array();
	public $timestamps = false;

	protected $fillable = array('video_id','artist_id');
}
