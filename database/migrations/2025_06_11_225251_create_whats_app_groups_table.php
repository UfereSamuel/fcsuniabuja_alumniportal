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
        Schema::create('whats_app_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('invite_link');
            $table->enum('type', ['general', 'zone', 'class', 'executive', 'special'])->default('general');
            $table->unsignedBigInteger('zone_id')->nullable(); // For zone-specific groups
            $table->unsignedBigInteger('class_id')->nullable(); // For class-specific groups
            $table->integer('member_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true); // Whether visible to all members
            $table->text('rules')->nullable(); // Group rules/guidelines
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->index(['type', 'is_active']);
            $table->index(['zone_id', 'is_active']);
            $table->index(['class_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whats_app_groups');
    }
};
