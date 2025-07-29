<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LiveStream;

class LivePurchase extends Model
{
    protected $table = 'live_purchases';
    
    protected $fillable = [
        'user_id',
        'video_id',
        'audio_id',
        'movie_id',
        'expired_date',
        'from_time',
        'to_time',
        'amount',
        'status',
        'livestream_view_count',
        'unseen_expiry_date',
        'payment_gateway',
        'payment_in',
        'platform',
        'payment_id',
        'payment_status',
        'total_amount',
        'payment_failure_reason',
        'ppv_plan',
    ];

    public function livestream() {
        return $this->belongsTo(LiveStream::class, 'video_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
