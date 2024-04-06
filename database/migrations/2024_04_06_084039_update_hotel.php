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
        Schema::table('hotel', function (Blueprint $table) {
            $table->string('TimeCheckIn', 20)->nullable()->change();
            $table->string('TimeCheckOut', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel', function (Blueprint $table) {
            $table->dateTime('TimeCheckIn', 20)->nullable()->change();
            $table->dateTime('TimeCheckOut', 20)->nullable()->change();
        });
    }
};
