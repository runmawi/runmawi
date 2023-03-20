<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgetPasswordLog extends Model
{
    protected $guarded = array();

    protected $table = 'forget_password_logs';

    public static $rules = array();
}
