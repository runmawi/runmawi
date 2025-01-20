<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('user_id', 'video_id','movie_id','episode_id','audio_id','ugc_video_id','live_id');

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function video(){
		return $this->belongsTo('Video')->first();
	}
}
