<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{

    protected $guarded = array();

    protected $table = 'like_dislikes';

    public static $rules = array();
}
