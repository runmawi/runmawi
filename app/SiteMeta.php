<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteMeta extends Model
{
    protected $guarded = array();

	protected $table = 'site_meta_settings';
	
	public static $rules = array();

}
