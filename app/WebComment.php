<?php

namespace App;

use App\CommentLikeDislike;
use Illuminate\Database\Eloquent\Model;

class WebComment extends Model
{
    protected $guarded = array();

    protected $table = 'webcomments';

    public static $rules = array();

    protected $fillable = [ 'user_id', 'user_name', 'first_letter', 'user_role', 'commenter_type', 'guest_name', 'guest_email', 'commentable_type', 'source', 'source_id', 'comment', 'approved', 'child_id', 'sub_child_id', 'comment_like', 'comment_dislike', 'has_liked', 'has_disliked'];

    public function child_comment() 
    {
        return $this->hasMany(WebComment::class,'child_id','id');
    }

    public function likes()
    {
        return $this->hasMany(CommentLikeDislike::class, 'comment_id')->where('type', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(CommentLikeDislike::class, 'comment_id')->where('type', 2);
    }

}
