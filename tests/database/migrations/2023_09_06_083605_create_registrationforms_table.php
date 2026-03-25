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
        Schema::create('registrationforms', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('course_id'); // foreign key for the course
        $table->unsignedBigInteger('campus_id'); // foreign key for the campus
        $table->string('student_name');
        $table->string('dob');
        $table->string('citizenship');
        $table->string('religion');
        $table->string('cityofresidence');
        $table->string('mobile');
        $table->string('emailadress');
        $table->string('homephone');
        $table->string('education');
        $table->string('otherskills');
        $table->string('profession');
        $table->string('gurdianname');
        $table->string('phonenumber');
        $table->string('idnumber');
        $table->string('gresidence');
        // Add a nullable column 'confirmation' and a text column 'describe'
        $table->string('medical_info_yes')->nullable();
        $table->text('medical_info_explanation')->nullable();

        $table->string('reasonfortraining');
        $table->string('gainfortraining');
        $table->boolean('data_is_true')->default(false);

        $table->string('file_name');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrationforms');
    }
};
