<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['title','genre_id','user_id','type','access','details','description','active','featured','duration','views','rating','image','embed_code','mp4_url','webm_url','ogg_url','language','year','trailer','url'];
}
