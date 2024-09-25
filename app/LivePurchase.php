<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Livestream;

class LivePurchase extends Model
{

    protected $table = 'live_purchases';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();

	public function livestream() {
        return $this->belongsTo(Livestream::class, 'video_id');
    }

}
