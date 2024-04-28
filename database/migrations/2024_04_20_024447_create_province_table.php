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
        Schema::create('province', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('DisplayName')->nullable(false);
            $table->string('Address', 512)->nullable(false);
            $table->string('Image')->default('default.jpg');
            $table->json('ProvinceNear')->nullable();
            $table->smallInteger('PopularRate')->default(0);
            $table->timestamps();
        });

        Schema::table('hotel', function (Blueprint $table) {
            $table->string('Province_Id', 50)->nullable(true);
            $table->foreign('Province_Id')->references('id')->on('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('province');

        Schema::table('hotel', function (Blueprint $table) {
            $table->dropForeign(['Province_Id']);
            $table->dropColumn('Province_Id');
        });
    }
};
