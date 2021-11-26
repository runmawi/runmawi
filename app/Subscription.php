<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    public function user_details(){
		return $this->hasMany('App\User','user_id','id');
	}
}
