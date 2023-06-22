<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgetPasswordLog extends Model
{
    protected $guarded = array();

    protected $table = 'forget_password_logs';

    public static $rules = array();

    protected $fillable = [
        'user_id',
        'email',
        'token',
        'status',
        'password_changed_time'
    ];
}
