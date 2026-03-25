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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable(); // Job title or position
            $table->string('company')->nullable(); // Company name
            $table->string('avatar')->nullable(); // Better column name than 'pic' for profile image
            $table->text('testimony');
            $table->integer('rating')->nullable()->unsigned()->between(1, 5); // Optional star rating (1-5)
            $table->boolean('is_active')->default(true); // To show/hide testimonial
            $table->integer('sort_order')->default(0); // For manual ordering
            $table->date('date')->nullable(); // When the testimonial was given
          
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};