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
        Schema::create('banner_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page')->nullable();
            $table->string('name')->nullable();
            $table->string('short_title')->nullable();
            $table->longText('long_title')->nullable();
            $table->string('image')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->boolean('status')->default(1)->nullable(); // 0 inactive, 1 active
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_sections');
    }
};
