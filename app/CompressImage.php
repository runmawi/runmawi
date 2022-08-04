<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompressImage extends Model
{
    protected $guarded = array();

    protected $table = 'compress_images';

    public static $rules = array();
}
