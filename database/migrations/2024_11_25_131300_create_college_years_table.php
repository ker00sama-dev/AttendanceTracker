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
        Schema::create('college_years', function (Blueprint $table) {
          $table->id();
          $table->string('year_name'); // e.g., "First Year", "Second Year", etc.
          $table->text('description')->nullable(); // Optional description
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('college_years');
    }
};
