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
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('Telephone')->unique()->change();
        // });
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
        //
    }
};
