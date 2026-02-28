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
        Schema::create('medical_packages', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('category')->nullable(); // Surgery, Treatment, etc.
            $table->string('duration')->nullable(); // e.g., "18 days"
            $table->integer('cities_count')->default(1);
            $table->string('price_range')->nullable(); // e.g., "$18,000 - $30,000"
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->json('features')->nullable(); // Store the bullet points
            $table->timestamps();
        });

        Schema::create('medical_package_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_package_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            
            $table->string('title');
            $table->string('subtitle')->nullable(); // For the Chinese text/secondary title
            $table->text('description')->nullable();

            $table->unique(['medical_package_id', 'locale'], 'pkg_trans_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_packages');
    }
};
