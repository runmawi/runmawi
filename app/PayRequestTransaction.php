<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayRequestTransaction extends Model
{
    protected $guarded = array();

    protected $table = 'pay_request_transaction';

    public static $rules = array();
}