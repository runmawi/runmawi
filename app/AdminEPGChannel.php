<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminEPGChannel extends Model
{
    protected $table = 'admin_epg_channels';

	protected $guarded = array();
    
	public static $rules = array();
}
