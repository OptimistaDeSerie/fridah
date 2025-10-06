<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function deliveryFee(){
        return $this->belongsTo(DeliveryFee::class, 'delivery_fee_id');
    }
}
