<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adsplan extends Model
{
    protected $table = 'ads_plans';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('plan_name','plan_amount','no_of_ads');
}
