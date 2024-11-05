<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partnerpayment extends Model
{
    protected $guarded = array();

    public static $rules = array();

    protected $table = 'partnerpayments';

    protected $fillable = ['user_id','amount','payment_date','notes','paid_amount','balance_amount'];

    public function channeluser()
    {
        return $this->belongsTo('App\Channel', 'user_id', 'id');
    }


}
