<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThemeIntegration extends Model
{
    protected $table = 'theme_integration';

    protected $fillable = [
        'theme_name',
        'theme_images',
        'created_at',
        'updated_at',
    ];

}
