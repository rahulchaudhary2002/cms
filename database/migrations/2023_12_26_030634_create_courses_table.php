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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('semester_id');
            $table->string('name');
            $table->string('course_code')->unique();
            $table->boolean('elective')->default(false);
            $table->integer('credit');
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
