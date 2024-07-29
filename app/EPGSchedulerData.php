<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EPGSchedulerData extends Model
{
    protected $table = 'epg_scheduler_datas';

    protected $guarded = array();
    
    public static $rules = array();

}
