<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = ['title','series_id','season_id','type','access','duration','views','rating','active','featured','image','mp4_url'];
}
