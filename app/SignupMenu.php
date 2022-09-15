<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class SignupMenu extends Model
{
    protected $guarded = array();

	protected $table = 'signup_details';
	
	public static $rules = array();


}
