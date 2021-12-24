<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevenueSetting extends Model
{
    protected $guarded = array();

    protected $table = 'revenue_settings';

    public static $rules = array();

}
