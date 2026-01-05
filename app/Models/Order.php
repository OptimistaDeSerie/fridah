<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_no',
        'subtotal',
        'total',
        'status',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
    /* 'user_id' (2nd argument) → foreign key in the addresses table.
    'user_id' (3rd argument) → local key in the orders table */
    public function defaultAddress(){
        return $this->hasOne(Address::class, 'user_id', 'user_id')
                    ->where('isdefault', 1);
    }
}
