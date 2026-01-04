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
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // e.g. "Organic Coffee"
            $table->string('subtitle')->nullable(); // e.g. "Special Blend"
            $table->string('short_text')->nullable(); // e.g. "Fresh!"
            $table->text('description')->nullable(); // e.g. "Breakfast products on sale"
            $table->string('offer_text')->nullable(); // e.g. "up to 50%"
            $table->string('bg_color')->default('#d9e2e1'); // Background color of the slide
            $table->string('text_position')->default('left'); // 'left' or 'right'
            $table->string('image'); // Stored image filename
            $table->integer('sort_order')->default(0); // For manual ordering
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sliders');
    }
};
