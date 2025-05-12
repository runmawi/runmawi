<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_type',
        'live_mode',
        'test_publishable_key',
        'test_secret_key',
        'live_publishable_key',
        'live_secret_key',
        'webhook_secret',
        'status'
    ];
}
