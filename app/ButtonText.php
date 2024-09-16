<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ButtonText extends Model
{
    protected $fillable = [
        'play_text',
        'subscribe_text',
        'purchase_text',
        'registered_text',
        'country_avail_text',
        'video_visible_text',
        'live_visible_text',
        'series_visible_text',
    ];
}
