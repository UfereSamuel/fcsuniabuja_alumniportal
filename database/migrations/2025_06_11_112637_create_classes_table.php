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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->integer('graduation_year')->unique();
            $table->string('slogan')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('coordinator_id')->nullable();
            $table->unsignedBigInteger('deputy_coordinator_id')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('class_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('coordinator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deputy_coordinator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
