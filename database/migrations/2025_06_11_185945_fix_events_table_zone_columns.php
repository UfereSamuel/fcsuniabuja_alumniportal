<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Handle zone_id column
        if (Schema::hasColumn('events', 'zone_id')) {
            try {
                // Try to drop foreign key first
                Schema::table('events', function (Blueprint $table) {
                    $table->dropForeign(['zone_id']);
                });
            } catch (Exception $e) {
                // Foreign key might not exist, continue
            }

            try {
                Schema::table('events', function (Blueprint $table) {
                    $table->dropColumn('zone_id');
                });
            } catch (Exception $e) {
                // Column might be in use, skip
            }
        }

        // Handle visibility column
        if (Schema::hasColumn('events', 'visibility')) {
            try {
                Schema::table('events', function (Blueprint $table) {
                    $table->dropColumn('visibility');
                });
            } catch (Exception $e) {
                // Column might be in use, skip
            }
        }

        // Add columns if they don't exist
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'zone_id')) {
                $table->foreignId('zone_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('events', 'visibility')) {
                $table->enum('visibility', ['national', 'zone_public', 'zone_private'])->default('national');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'zone_id')) {
                $table->dropForeign(['zone_id']);
                $table->dropColumn('zone_id');
            }
            if (Schema::hasColumn('events', 'visibility')) {
                $table->dropColumn('visibility');
            }
        });
    }
};
