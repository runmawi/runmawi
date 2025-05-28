<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveEventPurchase extends Model
{
    protected $table = 'live_event_purchases'; // Matches the migration

    protected $fillable = [
        'user_id',
        'live_id', // Specific to live events
        'payment_id', // Razorpay Order ID
        'razorpay_payment_id', // Actual Razorpay Payment ID
        'total_amount',
        'status',
        'payment_failure_reason',
        'payment_gateway',
        'platform',
        'ppv_plan',
        'to_time',
        'admin_commssion',
        'moderator_commssion',
        // Add any other fields specific to live event purchases
    ];

    // Relationships (examples, uncomment and adjust as needed)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function liveEvent() // Or LiveStream, Live, etc.
    // {
    //     return $this->belongsTo(LiveStream::class, 'live_id'); // Assuming LiveStream model
    // }
}
