<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeleteLog extends Model
{
    protected $table = 'delete_logs';
    protected $guarded = array();
    public static $rules = array();

}
