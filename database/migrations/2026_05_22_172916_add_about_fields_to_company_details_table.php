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
        Schema::table('company_details', function (Blueprint $table) {
            $table->text('about_us_en')->nullable();
            $table->text('about_us_bn')->nullable();
            $table->string('about_image1')->nullable();
            $table->string('about_image2')->nullable();
        });
    }

    public function down()
    {
        Schema::table('company_details', function (Blueprint $table) {
            $table->dropColumn(['about_us_en', 'about_us_bn', 'about_image1', 'about_image2']);
        });
    }
};
