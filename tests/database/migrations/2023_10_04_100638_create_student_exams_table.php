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
        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('user_id'); // Foreign key to associate exams with students
            $table->unsignedBigInteger('online_exam_id'); // Foreign key to associate exams with online exams
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->timestamps();

            // Define foreign key relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('online_exam_id')->references('id')->on('online_exams')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exams');
    }
};
