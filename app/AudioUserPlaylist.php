<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioUserPlaylist extends Model
{
    protected $guarded = array();

	protected $table = 'audio_user_playlist';
	
	public static $rules = array();
}
