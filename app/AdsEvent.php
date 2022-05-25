<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsEvent extends Model
{
    protected $table = 'ads_events';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = [
        'title', 'start', 'end','ads_category_id','color'
    ];
}
