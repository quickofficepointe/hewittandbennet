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
        Schema::create('courseapplications', function (Blueprint $table) {
            $table->id();
             $table->string('name');
    $table->string('email');
    $table->string('location');
    $table->string('phoneNumber');

    // Replace string 'course' with foreign key
    $table->foreignId('course_id')->constrained()->onDelete('cascade');

    // Add campus_id foreign key (assuming you have a campuses table)
    $table->foreignId('campus_id')->constrained()->onDelete('cascade');

    $table->string('startMonth');
    $table->string('startYear');
    $table->string('status')->nullable();
    $table->string('modeOfLearning');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courseapplications');
    }
};