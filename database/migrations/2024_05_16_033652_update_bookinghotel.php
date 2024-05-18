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
        Schema::table('bookinghotel', function (Blueprint $table) {
            $table->timestamp('ConfirmAt')->nullable(true)->change();
            $table->string('GiftCode')->nullable(true);
            $table->double('GiftCodePrice')->nullable(true);
            $table->integer('VAT')->default(0);
        });

        Schema::table('poster', function (Blueprint $table) {
            $table->boolean('HaveGitCode')->default(0);
            $table->string('GiftCode')->nullable(true);
            $table->boolean('SubstractWithPercent')->nullable(true); //giam theo % = true; giam theo so tien =false
            $table->double('GiftCodePrice')->nullable(true);
            $table->double('GiftCodePercent')->nullable(true);
            $table->date('EndDate')->nullable(true);
            $table->boolean('PosterIsUse')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookinghotel', function (Blueprint $table) {
            $table->dropColumn('GiftCode');
            $table->dropColumn('GiftCodePrice');
            $table->dropColumn('VAT');
        });

        Schema::table('poster', function (Blueprint $table) {
            $table->dropColumn('HaveGitCode');
            $table->dropColumn('GiftCode');
            $table->dropColumn('SubstractWithPercent');
            $table->dropColumn('GiftCodePrice');
            $table->dropColumn('GiftCodePercent');
            $table->dropColumn('EndDate');
        });
    }
};