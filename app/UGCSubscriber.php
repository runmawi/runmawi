<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UGCSubscriber extends Model
{
    protected $guarded = array();

    protected $table = 'ugc_subscribers';

    public static $rules = array();

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }

}
