<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranslationLanguage extends Model
{
    protected $table = 'translation_languages';

	protected $guarded = array();
    
	public static $rules = array();

}
