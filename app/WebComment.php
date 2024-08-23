<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebComment extends Model
{
    protected $guarded = array();

    protected $table = 'webcomments';

    public static $rules = array();

    protected $fillable = [ 'user_id', 'user_name', 'first_letter', 'user_role', 'commenter_type', 'guest_name', 'guest_email', 'commentable_type', 'source', 'source_id', 'comment', 'approved', 'child_id', 'sub_child_id', 'comment_like', 'comment_dislike'];

    public function child_comment() 
    {
        return $this->hasMany(WebComment::class,'child_id','id');
    }
}
