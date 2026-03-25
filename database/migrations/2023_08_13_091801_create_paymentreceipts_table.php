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
          Schema::create('paymentreceipts', function (Blueprint $table) {
            $table->id();
            $table->string('ReceiptNo');
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable foreign key for the user
            $table->string('Name');
            $table->string('student_no');
            $table->string('contact');
            $table->decimal('Amount', 10, 2);
            $table->string('paymentfor');
            $table->string('modeofpayment');
            $table->unsignedBigInteger('served_by'); // Foreign key for the servedBy user
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('student_no')->references('student_no')->on('student_data');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('served_by')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentreceipts');
    }
};