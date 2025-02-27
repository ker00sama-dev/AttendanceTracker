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
    Schema::create('subjects', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description')->nullable(); // Description of the subject
      $table->foreignId('professor_id')->constrained('users')->cascadeOnDelete(); // Professor responsible
      $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete(); // Linked department
      $table->foreignId('instructor_id')->nullable()->constrained('users')->cascadeOnDelete(); // Optional instructor

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('subjects');
  }
};
