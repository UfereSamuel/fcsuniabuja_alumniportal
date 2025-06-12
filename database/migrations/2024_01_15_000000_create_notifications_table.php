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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['payment', 'zone_update', 'event', 'system', 'user_action'])->default('system');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who receives the notification
            $table->foreignId('zone_id')->nullable()->constrained()->onDelete('cascade'); // Zone-related notifications
            $table->string('icon')->default('fas fa-bell'); // FontAwesome icon class
            $table->string('color')->default('blue'); // Color theme (blue, green, red, yellow, etc.)
            $table->json('data')->nullable(); // Additional notification data
            $table->string('action_url')->nullable(); // URL to redirect when clicked
            $table->boolean('is_read')->default(false);
            $table->boolean('email_sent')->default(false); // Track if email was sent
            $table->timestamp('read_at')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['user_id', 'is_read']);
            $table->index(['type', 'created_at']);
            $table->index(['zone_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
