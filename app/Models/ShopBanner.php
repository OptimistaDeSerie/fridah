<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopBanner extends Model
{
    protected $table = 'shop_banners';

    protected $fillable = [
        'title', 'line_1', 'line_2', 'line_3', 'line_4', 'line_5',
        'button_text', 'button_link', 'image', 'sort_order', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}