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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->boolean('is_active');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('semester_id');
            $table->unique(['academic_year_id', 'semester_id']);
            $table->timestamps();

            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
