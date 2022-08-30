<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelPayout extends Model
{
    protected $guarded = array();

	protected $table = 'channel_payouts';

    public function name(){
        return $this->belongsTo('App\Channel','user_id','id');
    }
}
