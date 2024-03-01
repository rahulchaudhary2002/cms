<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $yearMonth = date('Ym');

        Schema::create('student_attendances_' . $yearMonth, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->date('date');
            $table->enum('status', ['present', 'absent']);
            $table->unique(['student_id', 'course_id', 'date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $yearMonth = date('Ym');

        Schema::dropIfExists('student_attendances_' . $yearMonth);
    }
};

