<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class ChannelSignupMenu extends Model
{
    protected $guarded = array();

	protected $table = 'channel_signup_details';
	
	public static $rules = array();


}
