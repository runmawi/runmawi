<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    //protected $guarded = array();
    
    protected $table = 'live_streams';
    
	public static $rules = array();

	protected $fillable = array('id','video_category_id', 'slug' , 'status' ,'title', 'details', 'description', 'featured','banner', 'footer', 'duration', 'image', 'mp4_url','language' ,'year','created_at','free_duration','pre_post_ads','mid_ads');

	public function tags(){
		return $this->belongsToMany('Tag');
	}

	public function categories(){
		return $this->belongsTo('App\LiveCategory','video_category_id','id');
	}

	public function videoresolutions(){
		return $this->hasMany('App\VideoResolution','video_id','id');
	}

	public function videosubtitles(){
		return $this->hasMany('App\VideoSubtitle','video_id','id');
	}

	public function mywishlisted(){
		return $this->belongsTo('App\Wishlist','id','video_id');
	}
    

	public function languages(){
		return $this->belongsTo('App\Language','language','id');
	}
	
	public function cppuser(){
		return $this->belongsTo('App\ModeratorsUser','user_id','id');
	}
		
	public function usernames(){
		return $this->belongsTo('App\User','user_id','id');
	}
}
