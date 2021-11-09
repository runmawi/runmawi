<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
}
