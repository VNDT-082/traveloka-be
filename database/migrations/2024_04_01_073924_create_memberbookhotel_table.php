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
        Schema::create('memberbookhotel', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            //$table->foreignId('BookHotelId')->constrained('bookinghotel');
            $table->string('BookHotelId', 50)->nullable(false);

            $table->string('FullName')->nullable(false);
            $table->date('DateOfBirth')->nullable();
            $table->boolean('Sex')->default(true);

            $table->timestamps();
            $table->foreign('BookHotelId')->references('id')->on('bookinghotel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberbookhotel');
    }
};