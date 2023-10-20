<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TVLoginCode extends Model
{
    protected $table = 'tv_login_code';
    protected $fillable = ['email', 'tv_code', 'status', 'uniqueId', 'type', 'tv_name', 'verifytoken'];

}