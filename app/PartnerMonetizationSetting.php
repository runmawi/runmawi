<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerMonetizationSetting extends Model
{
    protected $guarded = array();

    protected $table = 'partner_monetization_settings';

    public static $rules = array();
}
