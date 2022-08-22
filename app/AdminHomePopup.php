<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminHomePopup extends Model
{
    protected $table = 'admin_home_popups';
    protected $guarded = array();
    public static $rules = array();
}
