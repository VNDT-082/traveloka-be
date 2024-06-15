<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SeedListStaffTable extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $staffIds = DB::table('staff')->inRandomOrder()->limit(10)->pluck('id')->toArray();

        $hotelIds = DB::table('hotel')->inRandomOrder()->limit(10)->pluck('id')->toArray();

        foreach ($staffIds as $staffId) {
            foreach ($hotelIds as $hotelId) {
                $currentDateTime = date("YmdHis") . substr((string) microtime(true), 2, 6);
                $randomIdLS = "LS" . $currentDateTime . rand(0, 9999);

                $sql = "INSERT INTO `listStaff`(`id`, `StaffId`, `HotelId`, `Roles`, `Type`, `IsActive`, `Notes`) 
                        VALUES (?,?,?,?,?,?,?)";

                DB::insert($sql, [
                    $randomIdLS,
                    $staffId,
                    $hotelId,
                    "Admin",
                    "Admin",
                    1,
                    "",
                ]);
            }
        }
    }
}
