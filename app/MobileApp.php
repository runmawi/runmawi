<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileApp extends Model
{
    protected $guarded = array();

	public static $rules = array();

	public $timestamps = false;

	protected $fillable = array('id', 'splash_image', 'created_at', 'updated_at');

	protected $table = 'mobile_apps';
}
