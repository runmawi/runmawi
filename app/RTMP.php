<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RTMP extends Model
{
    protected $table = 'rtmp_url';

    protected $fillable = [
        'rtmp_url',
        'created_at',
        'updated_at',
    ];
}
