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
        Schema::create('zone_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Coordinator, Deputy Coordinator, Secretary, Treasurer
            $table->text('description')->nullable();
            $table->json('permissions')->nullable(); // Array of permissions like create_events, manage_members, etc.
            $table->boolean('is_national')->default(false); // True for National Executive roles
            $table->boolean('is_zonal')->default(true); // True for Zonal roles
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0); // For ordering roles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_roles');
    }
};
