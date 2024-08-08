<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebComment extends Model
{
    protected $guarded = array();

    protected $table = 'webcomments';

    public static $rules = array();

    protected $fillable = [
        'user_id', 'user_role', 'user_name', 'first_letter', 'commenter_type', 'commentable_type', 'source', 'source_id', 'comment', 'approved', 'likes', 'dislikes'
    ];

    public function child_comment() 
    {
        return $this->hasMany(WebComment::class,'child_id','id');
    }
}
