<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalMailDevice extends Model
{
    protected $guarded = array();

    protected $table = 'approval_mail_devices';

    public static $rules = array();
    
}
