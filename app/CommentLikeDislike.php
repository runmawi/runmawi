<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLikeDislike extends Model
{
    protected $fillable = ['comment_id', 'user_id', 'type'];
}
