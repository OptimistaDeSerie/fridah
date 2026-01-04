<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularCategorySlider extends Model
{
    protected $table = 'home_slider_popular_products';

    protected $fillable = [
        'title', 'count_text', 'link_url', 'image', 'sort_order', 'status'
    ];
}