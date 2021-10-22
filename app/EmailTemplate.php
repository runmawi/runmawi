<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('amin_email','host_email','email_port');
}
