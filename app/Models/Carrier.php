<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carrier extends Model
{
    protected $fillable = ['title'];

    public function deliveryFees()
    {
        return $this->hasMany(DeliveryFee::class, 'carrier_id');
    }
}