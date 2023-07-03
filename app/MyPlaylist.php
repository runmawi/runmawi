<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyPlaylist extends Model
{
    protected $guarded = array();

	protected $table = 'my_playlist';
	
	public static $rules = array();
}
