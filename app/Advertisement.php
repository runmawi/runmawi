<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('ads_name','ads_category','ads_position','ads_path','advertiser_id','status');

    public function categories(){
		return $this->belongsTo('App\Adscategory','ads_category','id');
	}
}
