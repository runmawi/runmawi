<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMusicStation extends Model
{
    protected $table = 'user_music_station';

	protected $guarded = array();
    
	public static $rules = array();

}
