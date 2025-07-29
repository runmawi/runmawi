<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveEventPurchase extends Model
{
    protected $table = 'live_event_purchases';

    protected $fillable = [
        'user_id',
        'live_event_id', // Matches database column
        'payment_id', // Razorpay Order ID
        'razorpay_payment_id', // Actual Razorpay Payment ID
        'total_amount',
        'status',
        'payment_gateway',
        'platform',
        'ppv_plan',
        'admin_commssion',
        'moderator_commssion',
        'moderator_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function liveEvent()
    {
        return $this->belongsTo(LiveStream::class, 'live_event_id');
    }
}
