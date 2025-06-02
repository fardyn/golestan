<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("offerings", function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained()->onDelete("cascade");
            $table->foreignId("teacher_id")->constrained()->onDelete("cascade");
            $table->foreignId("student_id")->constrained()->onDelete("cascade");
            $table->string("semester");  // e.g., "Fall 2024", "Spring 2025"
            $table->string("section")->nullable();  // e.g., "A", "B", "C"
            $table->enum("status", ["enrolled", "completed", "dropped"])->default("enrolled");
            $table->decimal("grade", 5, 2)->nullable();  // Allows grades like 85.50
            $table->timestamps();

            // Ensure a student can only be enrolled once in a course per semester
            $table->unique(["course_id", "student_id", "semester"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("offerings");
    }
};