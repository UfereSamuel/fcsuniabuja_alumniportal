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
        Schema::table('prayer_requests', function (Blueprint $table) {
            // Add the missing columns that the controller expects
            $table->text('prayer_request')->nullable(); // The actual prayer request text
            $table->string('requester_name')->nullable(); // Name of the person making the request
            $table->string('requester_email')->nullable(); // Email of the requester
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending'); // Status for admin approval
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prayer_requests', function (Blueprint $table) {
            $table->dropColumn(['prayer_request', 'requester_name', 'requester_email', 'status']);
        });
    }
};
