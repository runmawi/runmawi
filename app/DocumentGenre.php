<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentGenre extends Model
{
    protected $guarded = array();

    protected $table = 'document_genre';

    public static $rules = array();

}