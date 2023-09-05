<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['title','signature','discount_percentage','multiple_subscription_plan'];
}
