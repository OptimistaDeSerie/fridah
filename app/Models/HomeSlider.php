<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $table = 'home_sliders';

    protected $fillable = [
        'title', 'subtitle', 'short_text', 'description',
        'offer_text', 'text_position', 'image',
        'sort_order', 'status'
    ];
}