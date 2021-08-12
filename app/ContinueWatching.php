<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContinueWatching extends Model
{
    protected $fillable = array('videoid', 'episodeid', 'currentTime', 'watch_percentage', 'user_id','created_at', 'updated_at');

}
