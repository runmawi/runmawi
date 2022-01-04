<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geofencing extends Model
{
    protected $table = 'geofencing';

    protected $fillable = [
        'geofencing',
        'created_at',
        'updated_at',
    ];
}
