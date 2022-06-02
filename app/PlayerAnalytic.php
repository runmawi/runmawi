<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerAnalytic extends Model
{
	protected $guarded = array();

	protected $table = 'player_analytics';
	
	public static $rules = array();



	public function videos(){

        return $this->belongsTo('App\Video','id','videoid');
		
    }

	public function users(){

        return $this->belongsTo('App\User','id','user_id');

    }
}
