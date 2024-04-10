<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelRoles extends Model
{
    protected $guarded = array();

    protected $table = 'channel_roles';
    
    public static $rules = array();

}
