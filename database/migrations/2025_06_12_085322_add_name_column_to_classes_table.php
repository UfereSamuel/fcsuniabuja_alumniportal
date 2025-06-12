<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ClassModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        // Update existing records to populate the name field
        $classes = ClassModel::all();
        foreach ($classes as $class) {
            $name = $class->slogan
                ? "Class {$class->graduation_year} - {$class->slogan}"
                : "Class {$class->graduation_year}";
            $class->update(['name' => $name]);
        }

        // Make the name column required after populating data
        Schema::table('classes', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropColumn('name');
        });
    }
};
