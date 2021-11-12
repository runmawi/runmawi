<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    //protected $guarded = array();
    
    protected $table = 'live_streams';
    
	public static $rules = array();

	protected $fillable = array('id','video_category_id', 'slug' , 'status' ,'title', 'details', 'description', 'featured','banner', 'footer', 'duration', 'image', 'mp4_url','language' ,'year','created_at');

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
	
	public function cppuser(){
		return $this->belongsTo('App\ModeratorsUser','user_id','id');
	}
}
