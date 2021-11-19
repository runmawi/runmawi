<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertiserplanhistory extends Model
{
    protected $table = 'advertiser_plan_history';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('plan_id','advertiser_id','status','ads_limit','no_of_uploads');
}
