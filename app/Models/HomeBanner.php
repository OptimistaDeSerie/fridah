<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    protected $table = 'home_banners';

    protected $fillable = [
        'title', 'subtitle', 'short_text', 'description',
        'banner_type', 'image', 'sort_order', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}