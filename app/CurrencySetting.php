<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencySetting extends Model
{
    protected $table = 'currency_settings';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
}
