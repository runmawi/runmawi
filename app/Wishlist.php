<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'mywishlists';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('user_id','ugc_video_id', 'video_id','movie_id','episode_id','users_ip_address','type', 'livestream_id' ,'episode_id' ,'audio_id');

	public function user(){
		return $this->belongsTo('User')->first();
	}

	public function video(){
		return $this->belongsTo('Video')->first();
	}
}
