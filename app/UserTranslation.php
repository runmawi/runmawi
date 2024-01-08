<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTranslation extends Model
{
    protected $table = 'user_translations';

	protected $guarded = array();
    
	public static $rules = array();

}
