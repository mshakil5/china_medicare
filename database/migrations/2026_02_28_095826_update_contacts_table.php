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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('full_name')->after('id')->nullable();
            $table->string('country')->nullable()->after('phone');
            $table->string('file')->nullable()->after('message');
            $table->dropColumn(['first_name','last_name','subject']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
