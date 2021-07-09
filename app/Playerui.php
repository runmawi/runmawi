<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playerui extends Model
{
	protected $guarded = array();

	protected $table = 'playerui';
	
	public static $rules = array();

    protected $fillable = ['show_logo','skip_intro','embed_player','watermark','thumbnail','advance_player','speed_control','video_card','subtitle','subtitle_preference','font','size','font_color','background_color','opacity'];
}
