<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multiprofile extends Model
{

    protected $table = 'sub_users';

    protected $fillable = [
        'parent_id',
        'user_name',
        'user_type',
        'Profile_Image',
        'FamilyMode',
        'Kidsmode',
        'created_at',
        'updated_at',
    ];
}
