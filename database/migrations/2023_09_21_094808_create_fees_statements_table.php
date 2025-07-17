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
        Schema::create('fees_statements', function (Blueprint $table) {
            $table->id();
            $table->string('student_no')->unique(); // Use student_no as the unique identifier
            $table->decimal('course_fee', 10, 2); // Course fee
            $table->decimal('paid_amount', 10, 2)->default(0); // Paid amount
            $table->decimal('remaining_amount', 10, 2)->default(0); // Remaining amount
            $table->timestamp('payment_date');
            // Add any other relevant fields for fee statements

            // Foreign Key Constraint to reference student_data by student_no
            $table->foreign('student_no')->references('student_no')->on('student_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_statements');
    }
};
