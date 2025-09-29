<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscriber';

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'amount',
        'payment_gateway',
        'gateway_subscription_id',
        'start_date',
        'end_date',
        'payment_status',
    ];
}
