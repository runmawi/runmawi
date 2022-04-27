<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryVideo extends Model
{
    protected $guarded = array();

    protected $table = 'categoryvideos';

    public static $rules = array();

	public function categoryname(){
		return $this->hasOne('App\VideoCategory','id','category_id');
	}
    public function VideoCategory()
    {
        return $this->belongsTo('App\Video');
    }
    public function categorynames()
    {
        return $this->belongsTo('App\Video','id','category_id');
    }
}
