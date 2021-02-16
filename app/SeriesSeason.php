<?php

namespace App;
use Episode;

use Illuminate\Database\Eloquent\Model;

class SeriesSeason extends Model
{
    protected $guarded = array();

	protected $table = 'series_seasons';
	
	public static $rules = array();

	protected $fillable = array('series_id');

	 public function episodes()
    {
        return $this->hasMany('App\Episode','season_id','id');
    }

}
