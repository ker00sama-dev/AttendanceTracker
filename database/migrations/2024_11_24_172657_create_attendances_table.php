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
        Schema::create('attendances', function (Blueprint $table) {
          $table->id();
          $table->foreignId('lecture_id')->constrained()->cascadeOnDelete(); // Link to lecture
          $table->foreignId('student_id')->constrained('users')->cascadeOnDelete(); // Link to student (users table)
          $table->timestamp('scanned_at')->nullable(); // Time the student scanned QR code
          $table->enum('status', ['present', 'absent', 'late'])->default('present'); // Attendance status
          $table->string('remarks')->nullable(); // Additional notes
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
