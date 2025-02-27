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
    Schema::create('lectures', function (Blueprint $table) {
      $table->id();
      $table->string('topic');
      $table->foreignId('subject_id')->constrained()->cascadeOnDelete(); // Link to subject
      $table->foreignId('created_by')->constrained('users')->cascadeOnDelete(); // Who created the lecture
      $table->dateTime('start_time');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lectures');
  }
};
