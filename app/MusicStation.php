<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MusicStation extends Model
{
    protected $table = 'music_station';

	protected $guarded = array();
    
	public static $rules = array();

}
