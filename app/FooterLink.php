<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $table = 'footer_links';

    protected $fillable = [
        'name',
        'link',
        'created_at',
        'updated_at',
    ];
}
