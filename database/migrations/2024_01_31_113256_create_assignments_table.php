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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->date('date_given');
            $table->date('submission_date');
            $table->boolean('late_submission')->default(false);
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
