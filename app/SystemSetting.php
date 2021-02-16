<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
     protected $fillable = ['facebook', 'facebook_client_id', '	facebook_secrete_key', 'facebook_callback', 'google_client_id', '	google_secrete_key', 'google_callback', 'google'];
}
