<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminEPG extends Model
{
    protected $table = 'admin_epg';

	protected $guarded = array();
    
	public static $rules = array();

}
