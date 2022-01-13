<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChooseProfileScene extends Model
{
    protected $table = 'chooseprofile_screen';

    protected $fillable = [
        'choosenprofile_screen',
        'profile_name',
        'created_at',
        'updated_at',
    ];
}
