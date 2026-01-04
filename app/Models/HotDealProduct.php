<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotDealProduct extends Model{
    protected $table = 'hot_deal_products';

    protected $fillable = ['product_id', 'show_hot_label', 'sort_order', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}