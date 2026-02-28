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
        Schema::create('medical_services', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable(); // fa-stethoscope etc
            $table->string('color')->nullable(); // teal, blue, orange
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('medical_service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_service_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('features')->nullable();

            $table->unique(['medical_service_id', 'locale'], 'service_trans_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_services');
    }
};
