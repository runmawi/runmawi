<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviesSubtitles extends Model
{
    protected $fillable= array( 'movie_id','sub_language', 'shortcode', 'url' );
   
}
