<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class CPPSignupMenu extends Model
{
    protected $guarded = array();

	protected $table = 'cpp_signup_details';
	
	public static $rules = array();


}
