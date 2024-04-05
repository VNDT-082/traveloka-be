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
        Schema::create('liststaff', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            // $table->foreignId('StaffId')->constrained('staff');
            // $table->foreignId('HotelId')->constrained('hotel');

            $table->string('StaffId', 50)->nullable(false);
            $table->string('HotelId', 50)->nullable(false);

            //Quyen CRUD theo thu tu index =>
            //create=false(0); read=true(1); update=false(2); delete=false(3)
            $table->string('Roles')->default('false;true;false;false');
            $table->string('Type');
            $table->boolean('IsActive')->default(true);
            $table->string('Notes', 512);

            $table->timestamps();
            $table->foreign('StaffId')->references('id')->on('staff');
            $table->foreign('HotelId')->references('id')->on('hotel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liststaff');
    }
};
