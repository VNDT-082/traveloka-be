<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookinghotel', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            // $table->foreignId('GuestId')->constrained('guest');
            // $table->foreignId('RoomId')->constrained('room');
            $table->string('GuestId', 50)->nullable(false);
            $table->string('RoomId', 50)->nullable(false);
            $table->string('ConfirmBy', 50)->nullable();

            $table->dateTime('CreateDate');
            $table->double('Price')->nullable(false);
            $table->string('Gift', 512)->nullable();
            $table->smallInteger('Discount')->default(0);
            $table->boolean('State')->default(false);
            $table->string('Notes', 512)->nullable();
            $table->dateTime('TimeRecive')->nullable(false);
            $table->dateTime('TimeLeave')->nullable(false);
            $table->timestamp('ConfirmAt')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();
            $table->foreign('GuestId')->references('id')->on('guest');
            $table->foreign('RoomId')->references('id')->on('room');
            $table->foreign('ConfirmBy')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookinghotel');
    }
};
