<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';
    protected $guarded = [];
    public static $rules = [];

    protected $fillable = ['ads_name', 'ads_category', 'ads_position', 'ads_path', 'advertiser_id', 'status', 'gender', 'age', 'location'];

    public function categories()
    {
        return $this->belongsTo('App\Adscategory', 'ads_category', 'id');
    }
}
