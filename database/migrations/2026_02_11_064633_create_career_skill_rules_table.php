<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('career_skill_rules', function (Blueprint $table) {
    $table->id();

    $table->foreignId('career_domain_id')
          ->constrained('career_domains')
          ->cascadeOnDelete();

    $table->foreignId('skill_id')
          ->constrained('skills')
          ->cascadeOnDelete();

    $table->boolean('is_mandatory')->default(false);

    $table->unsignedInteger('weight')->default(1);

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('career_skill_rules');
    }
};
