<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    protected $guarded = array();

    protected $table = 'captchas';

    public static $rules = array();
}
