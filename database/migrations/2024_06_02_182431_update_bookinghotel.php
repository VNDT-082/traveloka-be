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
            $table->smallInteger('State')->nullable(false)->change();
            $table->string('cancellation_reason', 512)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookinghotel', function (Blueprint $table) {
            $table->dropColumn('cancellation_reason');
        });
    }
};
