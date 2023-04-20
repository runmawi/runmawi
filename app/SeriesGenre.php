<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesGenre extends Model
{
    protected $guarded = array();

    protected $table = 'series_genre';

    public static $rules = array();

    public function specific_category_series()
    {
        return $this->belongsToMany(Series::class, 'series_categories','category_id','series_id');
    }

    public function category_series()
    {
        return $this->belongsToMany( 'App\Series','series_categories','category_id','series_id');
    }

}
