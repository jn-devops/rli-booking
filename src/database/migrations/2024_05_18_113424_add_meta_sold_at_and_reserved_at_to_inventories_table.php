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
        Schema::table('inventories', function (Blueprint $table) {
            $table->schemalessAttributes('meta')->after('property_code');
            $table->json('mappings')->after('meta')->nullable();
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('sold_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('meta');
            $table->dropColumn('mappings');
            $table->dropColumn('reserved_at');
            $table->dropColumn('sold_at');
        });
    }
};
