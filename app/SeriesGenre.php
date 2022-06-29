<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesGenre extends Model
{
    protected $guarded = array();

    protected $table = 'series_genre';

    public static $rules = array();
}
