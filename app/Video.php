<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
   
    protected $guarded = array();
    
     protected $dates = [
        'converted_for_streaming_at',
    ];

	public static $rules = array();

	protected $fillable = array('user_id', 'video_category_id', 'slug' , 'status' ,'title', 'subtitle', 'type', 'access', 'details', 'description', 'active', 'featured','banner', 'footer', 'duration', 'image', 'embed_code', 'mp4_url', 'webm_url', 'ogg_url','views','rating','language' ,'year','trailer','created_at','path','Recommendation','country');

	public function tags(){
		return $this->belongsToMany('Tag');
	}

	public function categories(){
		return $this->belongsTo('App\VideoCategory','video_category_id','id');
	}

	public function cppuser(){
		return $this->belongsTo('App\ModeratorsUser','user_id','id');
	}
	public function mywishlisted(){
		return $this->belongsTo('App\Wishlist','id','video_id');
	}
	public function mywatchlatered(){
		return $this->belongsTo('App\Wishlist','id','video_id');
	}
	public function videoresolutions(){
		return $this->hasMany('App\VideoResolution','video_id','id');
	}

	public function videosubtitles(){
		return $this->hasMany('App\VideoSubtitle','video_id','id');
	}

	public function languages(){
		return $this->belongsTo('App\Language','language','id');
	}
    
    public function cnt_watch(){
		return $this->hasMany('App\ContinueWatching','videoid','id');
	}

    public function channelVideo(){
        
            return $this->hasMany('App\Video', 'id');
    }

	public function comments(){
		return $this->hasMany('App\Comment')->orderBy('id','desc');
	}

    
}
