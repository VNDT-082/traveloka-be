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
        Schema::create('wards', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('name', 255);
            $table->string('name_en', 255);
            $table->string('full_name', 255);
            $table->string('full_name_en', 255);
            $table->string('code_name', 255);
            $table->string('district_code', 50);
            $table->integer('administrative_unit_id');
            $table->timestamps();

            $table->foreign('district_code')->references('code')->on('districts');
            $table->foreign('administrative_unit_id')->references('id')->on('administrative_units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
