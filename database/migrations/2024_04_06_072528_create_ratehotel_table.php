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
        Schema::create('ratehotel', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('HotelId', 50)->nullable(false);
            $table->string('GuestId', 50)->nullable(false);
            $table->smallInteger('Rating')->nullable(false); //he 10
            $table->string('Description', 512)->nullable();
            $table->smallInteger('Sach_Se')->nullable(false); //theo sao toi da 5 sao
            $table->smallInteger('Thoai_Mai')->nullable(false); //theo sao toi da 5 sao
            $table->smallInteger('Dich_Vu')->nullable(false); //theo sao toi da 5 sao
            $table->json('HinhAnh')->nullable(); //luu duoi dang json cach nhau sau do chuyen thanh array
            //VD: 'h1.jpg;h2.jpg;...'

            $table->timestamps();

            $table->foreign('HotelId')->references('id')->on('hotel');
            $table->foreign('GuestId')->references('id')->on('guest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratehotel');
    }
};
