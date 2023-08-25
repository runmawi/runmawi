<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';
	protected $guarded = array();
	public static $rules = array();

	protected $fillable = array('artist_name','artist_email','description','image','artist_slug','artist_type','user_id','uploaded_by');
}
