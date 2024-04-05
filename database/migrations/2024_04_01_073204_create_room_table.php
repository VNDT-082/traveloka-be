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
        Schema::create('room', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            //$table->foreignId('TypeRoomId')->constrained('typeroom');
            $table->string('TypeRoomId', 50)->nullable(false);

            $table->boolean('State')->default(false);
            $table->dateTime('TimeRecive')->nullable();
            $table->dateTime('TimeLeave')->nullable();
            $table->string('Gift', 512)->nullable();
            $table->smallInteger('Discount')->default(0);
            $table->boolean('Breakfast')->default(false);
            $table->boolean('Wifi')->default(false);
            $table->boolean('NoSmoking')->default(true);
            $table->boolean('Cancel')->default(false);
            $table->boolean('ChangeTimeRecive')->default(false);

            $table->timestamps();
            $table->foreign('TypeRoomId')->references('id')->on('typeroom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
    }
};
