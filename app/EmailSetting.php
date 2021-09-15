<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $table = 'email_settings';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('amin_email','host_email','email_port');
}
