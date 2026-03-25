<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseregistrationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courseregistrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('location');
            $table->string('phoneNumber');
            $table->string('course');
            $table->string('startMonth');
            $table->string('startYear');
            $table->string('status')->nullable();
            $table->string('modeOfLearning'); // Add the mode of learning field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courseregistrations');
    }
}
