<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model
{
    protected $fillable = ['state_id', 'carrier_id', 'price', 'weight_id'];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }

    public function weight()
    {
        return $this->belongsTo(Weight::class, 'weight_id');
    }
}