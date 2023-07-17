<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsViewCount extends Model
{
    protected $table = 'ads_views_count';
    protected $guarded = array();
    public static $rules = array();

}
