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
        Schema::table('users', function (Blueprint $table) {
            $table->string('id', 50)->change();
            $table->string('Telephone')->unique()->change();
            $table->string('Type')->change();
            $table->boolean('IsActive')->default(true)->change();
        });
        Schema::table('staff', function (Blueprint $table) {
            $table->dropForeign(['UserAccountId']);
            $table->foreign('UserAccountId')->references('id')->on('users');
        });

        Schema::table('guest', function (Blueprint $table) {
            $table->dropForeign(['UserAccountId']);
            $table->foreign('UserAccountId')->references('id')->on('users');
        });
        Schema::dropIfExists('accountuser');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->id()->change();
            $table->dropColumn('id');
            $table->increments('id');
        });
        Schema::create('accountuser', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('Email')->unique();
            $table->string('Telephone')->unique();
            $table->rememberToken('Token');
            $table->string('Type')->change();
            $table->boolean('IsActive')->default(true);
            $table->string('Password');

            $table->timestamps();
        });
        Schema::table('staff', function (Blueprint $table) {
            $table->dropForeign(['UserAccountId']);
            $table->foreign('UserAccountId')->references('id')->on('users');
        });

        Schema::table('guest', function (Blueprint $table) {
            $table->dropForeign(['UserAccountId']);
            $table->foreign('UserAccountId')->references('id')->on('users');
        });
        Schema::dropIfExists('accountuser');
    }
};
