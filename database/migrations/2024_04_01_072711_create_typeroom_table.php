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
        Schema::create('typeroom', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('HotelId', 50)->nullable(false);

            $table->string('Name')->nullable(false);
            $table->text('ConvenientRoom')->nullable();
            $table->text('ConvenientBathRoom')->nullable();
            $table->integer('FloorArea')->nullable();
            $table->smallInteger('MaxQuantityMember')->default(2);
            $table->double('Price')->default(0);
            $table->boolean('Voi_Tam_Dung')->default(false);
            $table->boolean('Ban_Cong_San_Hien')->default(false);
            $table->boolean('Khu_Vuc_Cho')->default(false);
            $table->boolean('May_Lanh')->default(false);
            $table->boolean('Nuoc_Nong')->default(false);
            $table->boolean('Bon_Tam')->default(false);

            $table->timestamps();
            $table->foreign('HotelId')->references('id')->on('hotel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typeroom');
    }
};
