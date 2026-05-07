<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeGalleryFilePathNullable extends Migration
{
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
            $table->string('title')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('file_path')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
        });
    }
}