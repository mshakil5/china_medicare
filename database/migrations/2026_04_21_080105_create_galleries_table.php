<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video']);
            $table->string('file_path');
            $table->string('thumbnail')->nullable(); 
            $table->string('link')->nullable(); 
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};