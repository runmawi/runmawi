<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerSeekTimeAnalytic extends Model
{
	protected $guarded = array();

	protected $table = 'player_seektime_analytics';
	
	public static $rules = array();

}
