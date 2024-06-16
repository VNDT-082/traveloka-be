<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $typerooms = DB::table('typeroom')->pluck('id');

        foreach ($typerooms as $TypeRoomId) {
            for ($i = 0; $i < 5; $i++) {
                $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
                $randomIdRoom = "RO" . $currentDateTime . rand(0, 9999);

                DB::table('room')->insert([
                    'id' => $randomIdRoom,
                    'TypeRoomId' => $TypeRoomId,
                    'State' => $faker->numberBetween(0, 1),
                    'TimeRecive' => $faker->dateTime,
                    'TimeLeave' => $faker->dateTime,
                    'Gift' => $faker->numberBetween(0, 1),
                    'Discount' => $faker->numberBetween(0, 100),
                    'Breakfast' => $faker->numberBetween(0, 1),
                    'Wifi' => $faker->numberBetween(0, 1),
                    'NoSmoking' => $faker->numberBetween(0, 1),
                    'Cancel' => $faker->numberBetween(0, 1),
                    'ChangeTimeRecive' => $faker->numberBetween(0, 1),
                    'RoomName' => $faker->word . $i,
                    'Hinh_Thuc_Thanh_Toan' => $faker->numberBetween(0, 1),
                    'Bao_Gom_Thue_Va_Phi' => $faker->numberBetween(0, 1),
                    'created_at' => date("YmdHis"),
                ]);
            }
        }
    }
}
