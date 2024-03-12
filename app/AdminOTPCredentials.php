<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminOTPCredentials extends Model
{
    protected $table = 'admin_otp_credentials';

    protected $guarded = array();

    public static $rules = array();
}
