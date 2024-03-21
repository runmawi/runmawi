<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminAccessPermission extends Model
{
    protected $table = 'admin_access_permissions';

	protected $guarded = array();
    
	public static $rules = array();
}
