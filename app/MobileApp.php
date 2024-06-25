<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileApp extends Model
{
    protected $guarded = array();

	public static $rules = array();

	public $timestamps = false;

	protected $fillable = array('id', 'splash_image','andriod_splash_image' ,'ios_device_version','created_at', 'updated_at');

	protected $table = 'mobile_apps';
}
