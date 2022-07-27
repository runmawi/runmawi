<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeratorPayout extends Model
{
    protected $guarded = array();

	protected $table = 'moderator_payouts';

    public function name(){
        return $this->belongsTo('App\ModeratorsUser','user_id','id');
    }
}
