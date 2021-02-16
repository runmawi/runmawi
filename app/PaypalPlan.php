<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalPlan extends Model
{
   protected $fillable = ['_token','name','plan_id','price'];
}
