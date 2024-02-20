<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LivePurchase extends Model
{

    protected $table = 'live_purchases';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
}
