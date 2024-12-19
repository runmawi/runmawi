<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoAnalytics extends Model
{
    protected $table = 'video_analytics';
	protected $guarded = array();
	public static $rules = array();

    protected $fillable = ['source_id', 'source_type', 'location', 'device', 'browser','viewed_in'];
}