<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',             // ← Required for mass assignment
        //'order_id',            // ← Also needed
        'mode',
        'status',
        'paystack_reference',
        'subtotal',
        'delivery_fee',
        'delivery_fee_id',
        'amount',
        'paystack_response',
        'cart_snapshot',
    ];

    protected $casts = [
        'cart_snapshot' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
