<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, drop the wrong constraint
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['delivery_fee_id']); // Laravel infers the name
        });

        // Then add the correct one pointing to delivery_fees
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('delivery_fee_id')
                  ->references('id')
                  ->on('delivery_fees')
                  ->onDelete('cascade'); // or 'set null' if you prefer
        });
    }

    public function down()
    {
        // If you ever rollback, drop the correct one and restore the old (wrong) one
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['delivery_fee_id']);
            
            // Only if you want to be able to rollback fully
            $table->foreign('delivery_fee_id')
                  ->references('id')
                  ->on('states')
                  ->onDelete('cascade');
        });
    }
};