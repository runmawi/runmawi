<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SeriesSeason;
use App\Episode;

class Series extends Model
{
    protected $fillable = ['title','genre_id','user_id','type','access','details','description','active','featured','duration','views','rating','image',
                            'embed_code','mp4_url','webm_url','ogg_url','language',
                            'year','trailer','url','banner','player_image','search_tag','network_id'];

                    
    public function Series_depends_episodes()
    {
        return $this->hasMany(Episode::class, 'series_id')->where('active',1)->where('status',1)->latest('season_id')->orderBy('episode_order');
    }

    public function Series_depends_seasons()
    {
        return $this->hasMany(SeriesSeason::class);   
    }
    
	public function SeriesSeason()
	{
		return $this->hasMany(SeriesSeason::class, 'series_id', 'id');

	}
}