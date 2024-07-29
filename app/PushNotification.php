<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $guarded = array();

	protected $table = 'push_notifications';
}
