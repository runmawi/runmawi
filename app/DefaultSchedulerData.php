<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultSchedulerData extends Model
{
    protected $table = 'default_scheduler_datas';
    protected $guarded = array();
    public static $rules = array();

}
