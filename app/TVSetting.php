<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TVSetting extends Model
{
    protected $table = 'tv_settings';

	protected $guarded = array();
    
	public static $rules = array();

}
