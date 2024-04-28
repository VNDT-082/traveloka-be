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
        Schema::table('typeroom', function (Blueprint $table) {
            $table->string('TenLoaiGiuong', 128)->default('Giường');
            $table->smallInteger('SoLuongGiuong')->default(1);
            $table->boolean('Lo_Vi_Song')->default(false);
            $table->boolean('Tu_Lanh')->default(false);
            $table->boolean('May_Giat')->default(false);
            $table->boolean('No_Moking')->default(true);
        });

        Schema::table('room', function (Blueprint $table) {
            $table->string('RoomName', 256)->unique()->nullable(true);
            $table->boolean('Hinh_Thuc_Thanh_Toan')->default(true); //true:oofline<> false onl
            $table->boolean('Bao_Gom_Thue_Va_Phi')->default(false); //fale:chua co thue, true co thue
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('typeroom', function (Blueprint $table) {
            $table->dropColumn('Lo_Vi_Song');
            $table->dropColumn('Tu_Lanh');
            $table->dropColumn('May_Giat');
            $table->dropColumn('No_Moking');
        });

        Schema::table('room', function (Blueprint $table) {
            $table->dropColumn('RoomName');
            $table->dropColumn('Hinh_Thuc_Thanh_Toan'); //true:oofline<> false onl
            $table->dropColumn('Bao_Gom_Thue_Va_Phi'); //fale:chua co thue, true co thue
        });
    }
};
