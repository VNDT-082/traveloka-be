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
        Schema::create('message', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('FromUserId')->nullable(false);
            //la khoa ngoai tham thieu toi bang guest hoac staff, nhung khong set forign key
            // tham chieu khoa ngoai nay phu thuoc vao "Type"
            $table->string('ToHotelOrGuestId')->nullable(false);
            //la khoa ngoai tham chieu toi bang hotel hoac guest, nhung khong set forign key
            // tham chieu khoa ngoai nay phu thuoc vao "Type"
            //Neu la admin gui toi mot group guest -> gan ToHotelOrGuestId=Type cua Guest
            //Neu la thong bao toan he thong -> gan ToHotelOrGuestId=0
            //Viec xac nhan nguoi nhan phu thuoc vao Type va ToHotelOrGuestId
            $table->string('Information', 512)->nullable(false);
            $table->string('Url')->nullable();
            $table->string('State')->default(false);

            // Type la thong bao: chia lam 3 loai thong bao la: 
            // Thong bao cua nhan vien (Staff)
            // Thong bao cua khach hang (Guest)
            // AdminToStaff 
            // AdminToGruopTypeGuest
            // FormUserId phu thuoc vao type
            // ToStaffOfHotelId: la ma khach san, de cac nhan vien thuoc khach san 
            //co the xem tuy thuoc vao cac role
            $table->string('Type')->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};