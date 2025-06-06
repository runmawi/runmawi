<?php

namespace App;

use App\User;
use App\Audio;
use App\Video;
use App\Series;
use App\LiveStream;
use App\SeriesSeason;
use Illuminate\Database\Eloquent\Model;

class PpvPurchase extends Model
{
    protected $table = 'ppv_purchases';
    // protected $guarded = array(); // Prefer explicit $fillable for mass assignment
    public static $rules = array();

    protected $fillable = [
        'user_id',
        'audio_id',
        'movie_id',
        'series_id',
        'season_id',
        'episode_id',
        'video_id',
        'expired_date',
        'from_time',
        'to_time',
        'total_amount',
        'admin_commssion',
        'moderator_commssion',
        'status',
        'payment_failure_reason',
        'live_id',
        'moderator_id',
        'view_count',
        'channel_id',
        'payment_gateway',
        'payment_in',
        'platform',
        'ppv_plan',
        'payment_id', // Razorpay Order ID
        'razorpay_payment_id', // Actual Razorpay Payment ID
        'roku_tvcode',
        'update_by',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    // public function audio() {
    //     return $this->belongsTo(Audio::class, 'audio_id');
    // }

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function SeriesSeason()
    {
        return $this->belongsTo(SeriesSeason::class, 'season_id');
    }

    public function livestream()
    {
        return $this->belongsTo(LiveStream::class, 'livestream_id');
    }




    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
