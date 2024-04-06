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
        Schema::create('hotel', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('Name');
            $table->string('Address')->nullable();
            $table->string('Telephone')->unique();
            $table->text('Description')->nullable();
            $table->text('LocationDetail')->nullable();
            $table->boolean('IsActive')->default(false);
            $table->string('TimeCheckIn', 20)->nullable();
            $table->string('TimeCheckOut', 20)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_hotel');
    }
};
