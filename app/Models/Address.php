<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
            'user_id',
            'delivery_fee_id',
            'address',
            'type',
            'isdefault',
        ];
    public function deliveryFee(){
        return $this->belongsTo(DeliveryFee::class, 'delivery_fee_id');
    }
}
