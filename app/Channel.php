<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = array();

    protected $table = 'channels';
    
    public static $rules = array();

}
