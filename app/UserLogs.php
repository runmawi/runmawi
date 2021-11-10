<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    protected $table = 'ures_logs';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('regionname','countryname','cityname');
}
