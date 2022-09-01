<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelPackage extends Model
{
    protected $guarded = array();

    protected $table = 'channel_packages';
    
    public static $rules = array();
}
