<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    //
    protected $table = 'log_activity';

    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id', 'video_id', 'audio_id', 'live_id', 'series_id'
        , 'season_id', 'episode_id', 'video_category_id', 'audio_category_id', 'live_category_id', 'series_category_id'
        , 'episode_category_id', 'approved_video_id', 'approved_live_id', 'album_id' , 'video_language_id'
        , 'video_artist_id', 'live_language_id', 'live_artist_id' , 'audio_language_id', 'audio_artist_id'
        , 'series_language_id', 'series_artist_id'

    ];

    public function username(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function video_title(){
        return $this->belongsTo('App\Video','video_id','id');
    }

    public function video_category(){
        return $this->belongsTo('App\VideoCategory','video_category_id','id');
    }

    public function video_language(){
        return $this->belongsTo('App\LanguageVideo','video_language_id','id');
    }

    public function video_cast(){
        return $this->belongsTo('App\Videoartist','video_artist_id','id');
    }
}
