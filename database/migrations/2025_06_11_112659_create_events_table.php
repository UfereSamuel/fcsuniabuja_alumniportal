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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('venue_address')->nullable();
            $table->enum('type', ['conference', 'wedding', 'birthday', 'reunion', 'seminar', 'social', 'other'])->default('other');
            $table->boolean('is_free')->default(true);
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->integer('max_attendees')->nullable();
            $table->boolean('requires_rsvp')->default(false);
            $table->text('requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
