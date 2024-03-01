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
        Schema::create('assignment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_submission_id');
            $table->unsignedBigInteger('assignment_question_id');
            $table->string('grade')->nullable();
            $table->longText('answer')->nullable();
            $table->json('uploads')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            
            $table->foreign('assignment_submission_id')->references('id')->on('assignment_submissions');
            $table->foreign('assignment_question_id')->references('id')->on('assignment_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_answers');
    }
};
