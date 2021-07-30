<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeratorsRole extends Model
{
   public function permissions() {

    return $this->belongsToMany(ModeratorsPermission::class,'roles_permissions');
       
    }

    public function users() {

       return $this->belongsToMany(ModeratorsUser::class,'users_roles');

    }
}
