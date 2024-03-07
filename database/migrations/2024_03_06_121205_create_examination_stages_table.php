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
        Schema::create('examination_stages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('session_id');
            $table->timestamps();

            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('session_id')->references('id')->on('sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examination_stages');
    }
};
