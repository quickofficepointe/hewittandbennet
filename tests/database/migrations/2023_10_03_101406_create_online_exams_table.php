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
        Schema::create('online_exams', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->integer('duration')->nullable();
        $table->dateTime('start_time')->nullable();
        $table->dateTime('end_time')->nullable();
        $table->unsignedBigInteger('user_id'); // Foreign key to associate exams with users/tutors
        $table->enum('status', ['active', 'inactive', 'hidden'])->default('active');
        $table->unsignedBigInteger('course_id')->nullable(); // Foreign key to associate exams with courses
        $table->timestamps();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_exams');
    }
};
