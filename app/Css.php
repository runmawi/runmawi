<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Css extends Model
{
    // Specify the table name
    protected $table = 'css';

    // Allow mass assignment on 'custom_css'
    protected $fillable = ['custom_css'];
}