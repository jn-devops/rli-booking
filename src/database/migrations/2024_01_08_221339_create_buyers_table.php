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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('birthdate');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('id_type');
            $table->string('id_number');
            $table->string('id_image_url')->nullable();
            $table->string('selfie_image_url')->nullable();
            $table->string('id_mark_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
