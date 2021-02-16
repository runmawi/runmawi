<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponPurchase extends Model
{
     
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'ref_id');
    }
}
