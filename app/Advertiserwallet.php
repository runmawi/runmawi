<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertiserwallet extends Model
{
    protected $table = 'advertiser_wallet';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('campaign_id','advertiser_id','status','amount','payment_mode','transaction_id');
}
