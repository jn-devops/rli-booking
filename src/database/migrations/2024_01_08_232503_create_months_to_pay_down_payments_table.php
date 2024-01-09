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
        Schema::create('months_to_pay_down_payments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->integer('months');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('months_to_pay_down_payments');
    }
};
