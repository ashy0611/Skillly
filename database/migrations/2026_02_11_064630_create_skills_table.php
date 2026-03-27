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
    Schema::create('skills', function (Blueprint $table) {
    $table->id();
    $table->string('skill_name');

    // Standardized naming
    $table->enum('skill_type', ['technical', 'soft']);

    // For accurate extraction
    $table->text('keywords'); // comma-separated variations

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
