<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThumbnailSetting extends Model
{
    protected $table = 'thumbnail_setting';
    
    protected $fillable = [
        'title', 'age', 'rating', 'published_year', 
        'duration', 'category', 'featured', 'play_button',
        'free_or_cost_label','reels_videos','trailer'
    ];
}
