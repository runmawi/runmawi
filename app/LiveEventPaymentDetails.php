<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveEventPaymentDetails extends Model
{
    protected $guarded = array();

    protected $table = 'live_event_payment_details';

    public static $rules = array();
}
