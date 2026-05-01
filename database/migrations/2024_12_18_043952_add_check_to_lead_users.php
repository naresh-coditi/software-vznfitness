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
        Schema::table('lead_users', function (Blueprint $table) {
            $table->string('approach_status')->default(0)->after('status')->comment('0=>pending , 1=>done');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_users', function (Blueprint $table) {
            $table->dropColumn('approach_status');
        });
    }
};
