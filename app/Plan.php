<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['_token','plans_name','plan_id','billing_interval','type','days','price'];
}
