<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoExtractedImages extends Model
{
    protected $guarded = array();

    protected $table = 'video_extracted_images';
    
    public static $rules = array();

}
