<?php

namespace App;

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

}
