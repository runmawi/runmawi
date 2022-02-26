<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
  protected $table = 'subscriptions';

    protected $fillable = [
        'user_id','name','days','price','stripe_id','stripe_status','stripe_plan','quantity',
        'regionname','countryname','cityname','trial_ends_at','ends_at','created_at','updated_at','PaymentGateway'
    ];

    //
    public function user_details(){
		return $this->hasMany('App\User','user_id','id');
	}

  
}
