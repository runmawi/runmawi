<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCommission extends Model
{
    protected $table = 'video_commission';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('percentage');
}
