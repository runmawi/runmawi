<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockVideo extends Model
{
    protected $table = 'blockvideos_countries';

    protected $fillable = [
        'video_id',
        'country_id',
        'created_at',
        'updated_at',
    ];
}
