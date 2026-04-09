<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Add global SEO fields to the main table
        Schema::table('medical_packages', function (Blueprint $table) {
            $table->string('og_image')->nullable()->after('image');
            $table->string('canonical_url')->nullable()->after('og_image');
        });

        // 2. Add translatable SEO fields to the EXISTING translation table
        Schema::table('medical_package_translations', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    public function down()
    {
        // 1. Remove global SEO fields
        Schema::table('medical_packages', function (Blueprint $table) {
            $table->dropColumn(['og_image', 'canonical_url']);
        });

        // 2. Remove translatable SEO fields
        Schema::table('medical_package_translations', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);
        });
    }
};