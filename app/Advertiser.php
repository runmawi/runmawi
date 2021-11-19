<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;


class Advertiser extends Model
{
    use Billable;
    protected $table = 'advertisers';
    protected $guarded = array();
    public static $rules = array();

    protected $fillable = array('company_name','license_number','address','mobile_number','email_id');
}
