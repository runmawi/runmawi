<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUserChannelSubscriptionPlans extends Model
{
    protected $table = 'admin_user_channel_subscription_plans';

    protected $guarded = array();

    public static $rules = array();
}