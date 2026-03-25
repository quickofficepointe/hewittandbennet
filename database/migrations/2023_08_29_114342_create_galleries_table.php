<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_type')->nullable(); // 'image', 'video', etc.
            $table->timestamps(); // Add this if you want created_at/updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
