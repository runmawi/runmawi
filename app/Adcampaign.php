<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adcampaign extends Model
{
    protected $table = 'ads_campaign';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('title','cost','no_of_ads','cpv_advertiser','cpv_admin','start','end');
}
