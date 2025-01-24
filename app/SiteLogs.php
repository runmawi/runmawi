<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteLogs extends Model
{
    protected $guarded = array();

	protected $table = 'site_logs';
	
	public static $rules = array();

}
