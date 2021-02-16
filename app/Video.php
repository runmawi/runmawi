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

	protected $fillable = array('user_id', 'video_category_id', 'slug' , 'status' ,'title', 'subtitle', 'type', 'access', 'details', 'description', 'active', 'featured','banner', 'footer', 'duration', 'image', 'embed_code', 'mp4_url', 'webm_url', 'ogg_url','views','rating','language' ,'year','trailer','created_at');

	public function tags(){
		return $this->belongsToMany('Tag');
	}

	public function categories(){
		return $this->belongsTo('VideoCategory','video_category_id','id');
	}

	public function videoresolutions(){
		return $this->hasMany('VideoResolution','video_id','id');
	}

	public function videosubtitles(){
		return $this->hasMany('VideoSubtitle','video_id','id');
	}

	public function languages(){
		return $this->belongsTo('Language','language','id');
	}
    
    public function channelVideo(){
        
            return $this->hasMany('App\Video', 'id');
    }

	public function comments(){
		return $this->hasMany('App\Comment')->orderBy('id','desc');
	}
    
    
}
