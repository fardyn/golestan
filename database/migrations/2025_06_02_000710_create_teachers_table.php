<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("teachers", function (Blueprint $table) {
            $table->id();
            $table->string("teacher_id")->unique();  // Teacher ID (e.g., T12345)
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email")->unique();
            $table->string("phone")->nullable();
            $table->string("department");
            $table->string("title");  // e.g., Professor, Associate Professor, etc.
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("teachers");
    }
};