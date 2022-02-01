<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deploy extends Model
{
    protected $table = 'deploy';

    protected $fillable = [
        'Domain_name',
        'username',
        'password',
        'host',
        'port',
        'package',
    ];

}
