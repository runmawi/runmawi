<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adscategory extends Model
{
    protected $table = 'ads_categories';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('name');
}
