<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryVideo extends Model
{
    protected $guarded = array();

    protected $table = 'categoryvideo';

    public static $rules = array();

	public function categoryname(){
		return $this->hasOne('App\VideoCategory','id','category_id');
	}

}
