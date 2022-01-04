<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockAudio extends Model
{
    protected $table = 'block_audio_countries';

    protected $fillable = [
        'audio_id',
        'country',
        'created_at',
        'updated_at',
    ];
}
