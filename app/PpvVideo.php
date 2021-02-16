<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpvVideo extends Model
{
    protected $guarded = array();
    
    protected $table = 'ppv_videos';
    
	public static $rules = array();

	protected $fillable = array('id','user_id', 'video_category_id', 'slug' , 'status' ,'title', 'subtitle', 'type', 'access', 'details', 'description', 'active', 'featured','banner', 'footer', 'duration', 'image', 'embed_code', 'mp4_url', 'webm_url', 'ogg_url','views','rating','language' ,'year','trailer','created_at');

	public function tags(){
		return $this->belongsToMany('Tag');
	}

	public function categories(){
		return $this->belongsTo('PpvCategory','video_category_id','id');
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
    
}
