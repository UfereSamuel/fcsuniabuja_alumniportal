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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('zone_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('zone_role_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('zone_joined_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
            $table->dropForeign(['zone_role_id']);
            $table->dropColumn(['zone_id', 'zone_role_id', 'zone_joined_at']);
        });
    }
};
