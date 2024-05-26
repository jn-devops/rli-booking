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
        Schema::table('seller_commissions', function (Blueprint $table) {
            $table->string('project_code')->after('seller_id')->nullable()->index();
            $table->unique(['project_code', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_commissions', function (Blueprint $table) {
            $table->dropColumn('project_code');
        });
    }
};
