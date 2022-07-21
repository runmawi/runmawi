<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkingSetting extends Model
{

    protected $guarded = array();

    protected $table = 'deep_linking_settings';

    public static $rules = array();
}
