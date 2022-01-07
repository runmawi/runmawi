<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WelcomeScreen extends Model
{
    protected $table = 'welcome_screen';

    protected $fillable = [
        'name',
        'welcome_images',
        'created_at',
        'updated_at',
    ];
}