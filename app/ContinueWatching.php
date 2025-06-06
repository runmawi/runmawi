<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContinueWatching extends Model
{
    protected $table = 'continue_watchings';
    
    protected $fillable = array('videoid', 'episodeid', 'currentTime', 'watch_percentage','multiuser', 'user_id','created_at', 'updated_at');

}
