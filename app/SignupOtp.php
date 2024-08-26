<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignupOtp extends Model
{
    protected $guarded = array();

	protected $table = 'signup_otps';
	
	public static $rules = array();
}
