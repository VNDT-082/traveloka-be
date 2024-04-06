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
        Schema::create('convenienthotel', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            //$table->foreignId('HotelId')->constrained('hotel');
            $table->string('HotelId', 50)->nullable(false);

            $table->string('Title')->nullable(false);
            $table->string('ImageIcon')->default('ImageIconDefault.jpg');
            $table->string('Description')->nullable(false);
            //$table->json('Description')->nullable(false);
            $table->timestamps();
            $table->foreign('HotelId')->references('id')->on('hotel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenienthotel');
    }
};
