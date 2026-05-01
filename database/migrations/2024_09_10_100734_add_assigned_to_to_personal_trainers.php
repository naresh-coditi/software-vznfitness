<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('lead_users', function (Blueprint $table) {
        $table->unsignedBigInteger('assigned_to')->nullable();
    });

    DB::statement('UPDATE lead_users SET assigned_to = created_by WHERE created_by IS NOT NULL');

    Schema::table('lead_users', function (Blueprint $table) {
        $table->foreign('assigned_to')
              ->references('id')
              ->on('users')
              ->nullOnDelete()
              ->cascadeOnUpdate();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_users', function (Blueprint $table) {
            //
        });
    }
};
