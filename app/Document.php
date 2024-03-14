<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = array();

    protected $table = 'documents';

    public static $rules = array();

}