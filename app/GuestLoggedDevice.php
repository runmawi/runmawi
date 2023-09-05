<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestLoggedDevice extends Model
{
    
    protected $guarded = array();

    protected $table = 'guest_logged_devices';

    public static $rules = array();
}
