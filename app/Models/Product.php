<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function hotDeal(){
        return $this->hasOne(HotDealProduct::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function sizes(){
        return $this->hasMany(ProductSize::class);
    }

    // 🔥 Optional: Get lowest price for display
    public function getPriceAttribute(){
        return $this->sizes()->min('sale_price') ?? 0;
    }

    // 🔥 Optional: Check if any size is in stock
    public function getInStockAttribute(){
        return $this->sizes()->where('quantity', '>', 0)->exists();
    }
}
