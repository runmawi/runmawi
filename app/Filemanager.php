<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Filemanager extends Model
{
    protected $table = 'filemanagers';
	protected $guarded = array();
	public static $rules = array();

}
