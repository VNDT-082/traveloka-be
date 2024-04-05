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
        Schema::create('guest', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            //$table->foreign('UserAccountId')->constrained('accountuser');
            $table->string('UserAccountId', 50)->nullable(false);

            $table->string('Email')->unique();
            $table->string('Telephone')->unique();
            $table->string('Name');
            $table->string('CCCD')->unique();
            $table->boolean('Sex');
            $table->string('Type')->default('NewGuest');
            $table->string('Avarta')->default('AvartaDefault.jpg');;
            $table->date('DateOfBirth')->nullable();
            $table->boolean('IsActive')->default(true);

            $table->timestamps();
            $table->foreign('UserAccountId')->references('id')->on('accountuser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest');
    }
};
