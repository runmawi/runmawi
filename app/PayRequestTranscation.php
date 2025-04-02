<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayRequestTranscation extends Model
{
    protected $guarded = array();

    protected $table = 'pay_request_transcation_details';

    public static $rules = array();
}