<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
   
    protected $guarded = array();
    
     protected $dates = [
        'converted_for_streaming_at',
    ];

	public static $rules = array();

	protected $fillable = array('user_id','audio_category_id', 'title', 'status', 'slug', 'album_id', 'ppv_status', 'subtitle', 'type', 'access', 'details', 'description', 'active', 'featured', 'duration', 'image','mobile_image', 'mp3_url','year', 'created_at', 'updated_at','ios_ppv_price','ppv_price');

    public function categories(){
		return $this->belongsTo('App\AudioCategory','audio_category_id','id');
	}

	public function albums(){
		return $this->belongsTo('App\AudioAlbums','album_id','id');
	}
    
    public function audioartists(){
		return $this->belongsToMany('App\Audioartist');
	}
}
