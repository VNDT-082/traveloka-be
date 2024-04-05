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
        Schema::create('accountuser', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('Email')->unique();
            $table->string('Telephone')->unique();
            $table->rememberToken('Token');
            $table->string('Type');
            $table->boolean('IsActive')->default(true);
            $table->string('Password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountuser');
    }
};