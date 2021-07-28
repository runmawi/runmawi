<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audioartist extends Model
{
    protected $table = 'audio_artists';
	protected $guarded = array();
	public static $rules = array();
	public $timestamps = false;

	protected $fillable = array('audio_id','artist_id');
}
