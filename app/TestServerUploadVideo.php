<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class TestServerUploadVideo extends Model
{
    protected $guarded = array();

	protected $table = 'test_server_uploads';
	
	public static $rules = array();


}
