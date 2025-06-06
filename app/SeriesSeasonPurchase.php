<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesSeasonPurchase extends Model
{
    protected $table = 'series_season_purchases'; // Matches the migration

    protected $fillable = [
        'user_id',
        'series_id',
        'season_id',
        'payment_id', // Razorpay Order ID
        'razorpay_payment_id', // Actual Razorpay Payment ID
        'total_amount',
        'status',
        'payment_failure_reason',
        'payment_gateway',
        'platform',
        'ppv_plan',
        'to_time', // Added based on PpvPurchase and common needs
        'admin_commssion', // Added based on PpvPurchase
        'moderator_commssion', // Added based on PpvPurchase
        // Add any other fields specific to series/season purchases
    ];

    // Relationships (examples, uncomment and adjust as needed)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function series()
    // {
    //     return $this->belongsTo(Series::class);
    // }

    // public function season() // Or SeriesSeason model if it exists separately
    // {
    //     return $this->belongsTo(SeriesSeason::class, 'season_id');
    // }
}
