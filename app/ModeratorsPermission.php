<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeratorsPermission extends Model
{
   public function permissions() {

    return $this->belongsToMany(ModeratorsRole::class,'roles_permissions');
       
    }

    public function users() {

        return $this->belongsToMany(ModeratorsUser::class,'users_permissions');

}
}
