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
        Schema::table('orders', function (Blueprint $table) {
            // First, change the column to include 'pending'
            $table->enum('status', ['pending', 'ordered', 'delivered', 'canceled'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert back to original enum values
            // Note: Any existing 'pending' records will cause an error on rollback
            $table->enum('status', ['ordered', 'delivered', 'canceled'])
                  ->default('ordered')
                  ->change();
        });
    }
};
