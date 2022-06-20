<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedVideo extends Model
{
    protected $guarded = array();

    protected $table = 'related_videos';

    public static $rules = array();

}
