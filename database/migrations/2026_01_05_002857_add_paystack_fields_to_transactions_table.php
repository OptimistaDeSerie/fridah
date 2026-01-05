<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('paystack_reference')->nullable()->unique();
            $table->json('paystack_response')->nullable(); // full response for debugging
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['paystack_reference', 'paystack_response']);
        });
    }
};
