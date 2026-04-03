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
            Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // 🔥 Deletes sizes if product is deleted
            $table->string('size'); // e.g., "100g", "300g", "900g"
            $table->decimal('regular_price', 8, 2); // 🔥 Price before discount
            $table->decimal('sale_price', 8, 2);    // 🔥 Discounted price
            $table->integer('quantity')->default(0); // 🔥 Stock for this size
            $table->timestamps();

            // 🔥 Ensure unique size per product (no duplicate sizes for same product)
            $table->unique(['product_id', 'size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
