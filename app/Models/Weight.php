<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weight extends Model
{
    protected $fillable = ['title'];

    public function deliveryFees()
    {
        return $this->hasMany(DeliveryFee::class, 'weight_id');
    }
}