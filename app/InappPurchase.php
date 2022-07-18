<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InappPurchase extends Model
{
    protected $guarded = array();

    protected $table = 'inapp_purchases';

    public static $rules = array();
}
