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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->string('sku')->index();
            $table->string('property_code')->nullable();
            $table->integer('dp_percent')->nullable();
            $table->integer('dp_months')->nullable();
            $table->foreignId('buyer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('transaction_id')->nullable();
            $table->string('state')->nullable();
            $table->schemalessAttributes('meta');
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
