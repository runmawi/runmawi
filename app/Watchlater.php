<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchlater extends Model
{
    protected $guarded = array();

	protected $table = 'watchlaters';
	
	public static $rules = array();
}
