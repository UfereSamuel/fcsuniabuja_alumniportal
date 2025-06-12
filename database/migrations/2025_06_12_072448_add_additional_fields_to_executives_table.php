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
        Schema::table('executives', function (Blueprint $table) {
            $table->text('ministry_focus')->nullable()->after('bio');
            $table->integer('years_of_service')->nullable()->after('ministry_focus');
            $table->json('social_links')->nullable()->after('years_of_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('executives', function (Blueprint $table) {
            $table->dropColumn(['ministry_focus', 'years_of_service', 'social_links']);
        });
    }
};
