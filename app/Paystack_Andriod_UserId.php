<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paystack_Andriod_UserId extends Model
{
    protected $guarded = array();

	protected $table = 'paystack_andriod_user_id';
	
	public static $rules = array();
}
