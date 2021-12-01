<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoggedDevice extends Model
{
    protected $guarded = array();

    protected $table = 'logged_devices';

    public static $rules = array();

	public function user_name(){
		return $this->belongsTo('App\User','user_id','id');
	}
}
