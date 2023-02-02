<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentSection extends Model
{
    protected $guarded = array();

    protected $table = 'admin_comment_section';

    public static $rules = array();

}
