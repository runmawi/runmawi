<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MusicGenre extends Model
{
    protected $table = 'music_genre';

	protected $guarded = array();
    
	public static $rules = array();

}
