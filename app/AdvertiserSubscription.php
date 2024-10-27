<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiserSubscription extends Model
{
    protected $table = 'adverister_subscription';

    protected $guarded = array();
    
    public static $rules = array();
}
