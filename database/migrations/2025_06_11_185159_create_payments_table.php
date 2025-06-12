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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->enum('category', ['membership', 'event', 'donation'])->default('membership');
            $table->string('payment_reference')->unique(); // Paystack reference
            $table->string('paystack_reference')->nullable(); // Paystack transaction reference
            $table->enum('status', ['pending', 'successful', 'failed', 'abandoned'])->default('pending');
            $table->json('paystack_response')->nullable(); // Store Paystack response
            $table->text('description')->nullable();
            $table->string('payment_method')->nullable(); // card, bank_transfer, etc.
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
