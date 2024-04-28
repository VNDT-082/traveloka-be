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
        Schema::create('diadiemlancan', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('HotelId', 50)->nullable(false);
            $table->string('Name', 512)->nullable(false);
            $table->string('Category', 512)->default('Khác');
            $table->boolean('IsPopular')->default(false);
            $table->string('ImageIcon', 128)->default('location.webp');
            $table->string('Distance', 20)->default('location.webp');
            //bat chon dơn vi, va nhap khoang cach, nêu don vi m max=999m
            $table->foreign('HotelId')->references('id')->on('hotel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diadiemlancan');
    }
};
