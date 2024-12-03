<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadErrorLog extends Model
{
    protected $table = 'upload_error_log';

    protected $fillable = [
        'user_id',
        'user_ip',
        'socure_title',
        'socure_type',
        'error_message',
    ];
    
}