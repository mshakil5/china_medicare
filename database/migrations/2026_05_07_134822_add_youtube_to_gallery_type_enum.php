<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddYoutubeToGalleryTypeEnum extends Migration
{
    public function up()
    {
        // Change the ENUM to include 'youtube'
        DB::statement("ALTER TABLE galleries MODIFY COLUMN type ENUM('image', 'video', 'youtube') NOT NULL DEFAULT 'image'");
    }

    public function down()
    {
        // Revert back to original (Note: this will fail if any youtube rows exist)
        DB::statement("ALTER TABLE galleries MODIFY COLUMN type ENUM('image', 'video') NOT NULL DEFAULT 'image'");
    }
}