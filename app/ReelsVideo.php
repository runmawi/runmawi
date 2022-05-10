<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReelsVideo extends Model
{
    protected $table = 'reelsvideo';

    protected $fillable = [
        'video_id',
        'reels_videos',
        'reels_videos_slug',
        'created_at',
        'updated_at',
    ];
}
