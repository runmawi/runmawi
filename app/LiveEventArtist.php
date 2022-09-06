<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveEventArtist extends Model
{
    protected $guarded = array();

    protected $table = 'live_event_artists';

    public static $rules = array();
}
