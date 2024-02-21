<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpvPurchase extends Model
{
    protected $table = 'ppv_purchases';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array();
    
}
