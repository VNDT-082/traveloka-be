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
        Schema::create('administrative_units', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('full_name', 255);
            $table->string('full_name_en', 255);
            $table->string('short_name', 255);
            $table->string('short_name_en', 255);
            $table->string('code_name', 255);
            $table->string('code_name_en', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_units');
    }
};
