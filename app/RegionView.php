<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionView extends Model
{
    protected $table = 'region_views';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
}
