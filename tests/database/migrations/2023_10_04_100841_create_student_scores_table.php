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
    {Schema::create('student_scores', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('online_exam_id');
        $table->decimal('score', 5, 2);
        $table->unsignedBigInteger('student_id');
        $table->unsignedBigInteger('tutor_id'); // New column for student's user ID
        $table->timestamps();

        $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('online_exam_id')->references('id')->on('online_exams')->onDelete('cascade');
        $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key to associate scores with students
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_scores');
    }
};
