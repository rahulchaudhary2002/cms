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
        Schema::create('examination_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('examination_record_id');
            $table->unsignedBigInteger('course_id');
            $table->string('grade');
            $table->timestamps();

            $table->foreign('examination_record_id')->references('id')->on('examination_records');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examination_marks');
    }
};
