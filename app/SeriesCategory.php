<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesCategory extends Model
{
    protected $guarded = array();

    protected $table = 'series_categories';

    public static $rules = array();

    public function specific_category_series()
        {
            return $this->belongsToMany( 'App\Series','series_categories','category_id','series_id')->where('series.active',1);
        }
}
