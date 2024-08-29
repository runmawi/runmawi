<?php

namespace App;

use App\User;
use App\LikeDislike;
use Illuminate\Database\Eloquent\Model;

class UGCVideo extends Model
{
    protected $guarded = array();

    protected $table = 'ugc_videos';

    public static $rules = array();

    protected $fillable = array('user_id', 'slug' , 'status' ,'title', 
		'subtitle', 'type', 'details', 'description', 'active','duration', 'image', 'embed_code', 'mp4_url', 'webm_url', 'ogg_url','views',
		'created_at','path','country','search_tags','video_tv_image','free_duration_status',
	);

	public function user()
    {
        return $this->belongsTo(User::class);
    }

	public function likesDislikes()
	{
    	return $this->hasMany(LikeDislike::class, 'ugc_video_id');
	}

}
