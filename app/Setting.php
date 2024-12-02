<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = array();

	protected $table = 'settings';
	
	public static $rules = array();

    protected $fillable = ['title','signature','discount_percentage','multiple_subscription_plan','CPP_Commission_Status'];
}
