<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $guarded = array();

    protected $table = 'subscription_plans';

    public static $rules = array();


}
