<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    //
    protected $table = 'log_activity';

    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];

    public function username(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
