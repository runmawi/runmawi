<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
  protected $fillable = ['title','series_id','season_id','type','access','duration','views','rating','active','featured','image','mp4_url','path','free_content_duration','episode_description'];


    public function series_title(){
		    return $this->belongsTo('App\Series','series_id','id');
  	}

    public function series(){
      return $this->belongsTo('App\Series','series_id','id');
      return $this->belongsTo('App\Series','series_id','id');
  }

    public function channeluser(){
      return $this->belongsTo('App\Channel','user_id','id');
    }
}
