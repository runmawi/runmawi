<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebComment extends Model
{
    protected $guarded = array();

    protected $table = 'webcomments';

    public static $rules = array();

    public function child_comment() 
    {
        return $this->hasMany(WebComment::class,'child_id','id');
    }
}
