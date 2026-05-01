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
        Schema::table('user_membership_details', function (Blueprint $table) {
            $table->integer('interest_status')->nullable()->after('name')->comment('1=>Interested,2=>Not_Interested');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_membership_details', function (Blueprint $table) {
            $table->dropColumn('interest_status');
        });
    }
};
