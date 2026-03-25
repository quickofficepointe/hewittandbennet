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
        Schema::create('newsandevents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
    $table->string('slug')->unique(); // Unique index for the slug
    $table->string('cover_image')->nullable();
    $table->longText('content'); // Correct way to define LONGTEXT
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();

            // Adding index for title and content for faster searches
            $table->index('title');
            $table->index('content'); // Index content for full-text search optimization (if needed)
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsandevents');
    }
};