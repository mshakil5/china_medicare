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
        // Create Hero Sections Table
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('btn1_url')->nullable();
            $table->string('btn2_url')->nullable();
            // Stats (Storing as JSON for simplicity)
            $table->json('stats')->nullable(); 
            // Info Cards (JCI, Support - storing as JSON)
            $table->json('info_cards')->nullable(); 
            $table->timestamps();
        });

        // Create Hero Section Translations Table
        Schema::create('hero_section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_section_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();

            $table->string('badge')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('btn1_text')->nullable();
            $table->string('btn2_text')->nullable();

            $table->unique(['hero_section_id', 'locale']);
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
