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
        Schema::create('student_datas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('student_no')->unique();
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->decimal('fee_balance', 10, 2)->default(0.00);
            $table->string('id_number')->unique();
            $table->string('guardian_name'); // FIXED: Added $table->
            $table->string('guardian_phone_number');
            $table->string('guardian_email');
            $table->string('passport_photo');
            $table->string('course');
            $table->decimal('course_fee', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_datas');
    }
};
