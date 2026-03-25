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
        Schema::create('student_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            // Foreign key to associate responses with student exams
            $table->unsignedBigInteger('question_id'); // Foreign key to associate responses with questions
            $table->text('answers'); // Store the student's response text
            $table->timestamps(); // This line is kept once

            // Define foreign key relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_responses');
    }
};
