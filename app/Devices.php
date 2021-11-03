<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    protected $table = 'devices';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('amin_email','host_email','email_port');
}
