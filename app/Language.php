<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    
    protected $guarded = array();

    protected $table = 'languages';

    public static $rules = array();
}
