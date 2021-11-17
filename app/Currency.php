<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
}
