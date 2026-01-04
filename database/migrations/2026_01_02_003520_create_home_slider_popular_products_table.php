<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_slider_popular_products', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Cooking"
            $table->string('count_text'); // e.g., "4 Products"
            $table->string('link_url'); // e.g., "category/cooking" or full URL
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_slider_popular_products');
    }
};
