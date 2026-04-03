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
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('amount');
            $table->decimal('delivery_fee', 10, 2)->after('subtotal');
            $table->unsignedBigInteger('delivery_fee_id')->nullable()->after('delivery_fee');

            $table->json('cart_snapshot')->after('delivery_fee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'delivery_fee',
                'delivery_fee_id',
                'cart_snapshot',
            ]);
        });
    }
};
