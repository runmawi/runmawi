<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
   
    public function tags(){
		return $this->belongsToMany('Tag');
	}

	
}
