<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsTimeSlot extends Model
{
    protected $table = 'ads_time_slot';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('day','start_time','end_time');
}
