<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adsurge extends Model
{
    protected $table = 'ads_surge';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('title','start','end');
}
