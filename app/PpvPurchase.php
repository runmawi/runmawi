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
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
    
	public function video() {
        return $this->belongsTo(Video::class, 'video_id');
    }

    // public function audio() {
    //     return $this->belongsTo(Audio::class, 'audio_id');
    // }

    public function series() {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function SeriesSeason() {
        return $this->belongsTo(SeriesSeason::class, 'season_id');
    }

    public function livestream() {
        return $this->belongsTo(LiveStream::class, 'livestream_id');
    }


    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
