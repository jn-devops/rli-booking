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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('product_id');
            $table->string('sku')->nullable();
            $table->string('property_code')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sku')
                ->references('sku')
                ->on('products')
                ->onUpdate('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
