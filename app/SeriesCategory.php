<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesCategory extends Model
{
    protected $guarded = array();

    protected $table = 'series_categories';

    public static $rules = array();

    public function specific_category_episode()
        {
            return $this->belongsToMany( 'App\Episode','series_categories','category_id','series_id')
                            ->where('episodes.status',1)->where('episodes.active',1);
        }
}
