<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeratorSubscription extends Model
{
    protected $guarded = array();

    protected $table = 'moderator_subscriptions';

    public static $rules = array();

    public function user_details(){
		return $this->hasMany('App\User','user_id','id');
	}

}
