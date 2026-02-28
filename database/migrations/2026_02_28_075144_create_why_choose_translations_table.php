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
        Schema::create('why_choose_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('why_choose_id')->constrained()->onDelete('cascade');
            $table->string('locale'); // en, bn, ar etc
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->unique(['why_choose_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_choose_translations');
    }
};
