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
        Schema::create('imageshotel', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            //$table->foreignId('HotelId')->constrained('hotel');
            $table->string('HotelId', 50)->nullable(false);

            $table->string('TypeRoom')->default('All');
            $table->string('FileName')->nullable(false);

            $table->timestamps();
            $table->foreign('HotelId')->references('id')->on('hotel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imageshotel');
    }
};