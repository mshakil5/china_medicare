<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Add features JSON column to translations table
        Schema::table('medical_package_translations', function (Blueprint $table) {
            $table->json('features')->nullable()->after('meta_keywords');
        });

        // 2. (Optional) Migrate existing data before dropping
        // If you have existing features data, migrate it first:
        \App\Models\MedicalPackage::whereNotNull('features')->each(function ($pkg) {
            $enTranslation = $pkg->translate('en');
            if ($enTranslation && $pkg->features) {
                $enTranslation->features = $pkg->features;
                $enTranslation->save();
            }
        });

        // 3. Drop features from main table
        Schema::table('medical_packages', function (Blueprint $table) {
            $table->dropColumn('features');
        });
    }

    public function down()
    {
        Schema::table('medical_packages', function (Blueprint $table) {
            $table->json('features')->nullable();
        });

        Schema::table('medical_package_translations', function (Blueprint $table) {
            $table->dropColumn('features');
        });
    }
};
