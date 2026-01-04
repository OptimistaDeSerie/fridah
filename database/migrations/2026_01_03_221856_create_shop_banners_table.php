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
        Schema::create('shop_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // for admin reference
            $table->text('line_1')->nullable();  // e.g. "Fashion"
            $table->text('line_2')->nullable();  // e.g. "mega sale"
            $table->text('line_3')->nullable();  // e.g. "extra"
            $table->text('line_4')->nullable();  // e.g. "60% OFF"
            $table->text('line_5')->nullable();  // e.g. "On order above $555"
            $table->string('button_text')->nullable(); // e.g. "SHOP NOW"
            $table->string('button_link')->nullable();  // URL
            $table->string('image'); // filename
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
        Schema::dropIfExists('shop_banners');
    }
};
