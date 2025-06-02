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
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('semester');  // e.g., "Fall 2024"
            $table->string('section')->nullable();  // e.g., "A", "B"
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->string('grade', 4)->nullable();  // e.g., A, B+, etc.
            $table->timestamps();

            // Ensure a student can't be enrolled in the same course section twice
            $table->unique(['course_id', 'teacher_id', 'student_id', 'semester', 'section'], 'unique_enrollment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offerings');
    }
};
