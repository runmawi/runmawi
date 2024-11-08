<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChannelSubscription extends Model
{
    protected $table = 'users_channel_subscription';

	protected $guarded = array();

	public static $rules = array();
}
