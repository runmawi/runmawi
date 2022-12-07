<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLifeTimeSubscription extends Model
{
    protected $table = 'admin_lifetime_subscription';
    protected $guarded = array();
    public static $rules = array();

}
