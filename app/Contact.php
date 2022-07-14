<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = array();

    protected $table = 'contact_us';

    public static $rules = array();


}
