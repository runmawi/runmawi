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

    protected $fillable = array('user_id', 'video_category_id', 'slug' , 'status' ,'title', 
		'subtitle', 'type', 'access', 'details', 'description', 'active', 'featured','banner', 
		'footer', 'duration', 'image', 'embed_code', 'mp4_url', 'webm_url', 'ogg_url','views','rating',
		'language' ,'year','trailer','created_at','path','Recommendation','country','pdf_files',
		'reelvideo','url_link','url_linktym','url_linksec','urlEnd_linksec','search_tags',
		'trailer_description','trailer_type','reels_thumbnail','tag_url_ads_position','video_tv_image','free_duration_status',
		'video_js_pre_position_ads','video_js_post_position_ads','video_js_mid_position_ads_category',
		'video_js_mid_advertisement_sequence_time','today_top_video'
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
