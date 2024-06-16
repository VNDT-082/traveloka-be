<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class HotelSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $currentDateTime = date("YmdHis") . $i;
            $randomIdHotel = "HT" . $currentDateTime;
            DB::table('hotel')->insert([
                'id' => $randomIdHotel,
                'Name' => $faker->company,
                'Address' => $faker->address,
                'Telephone' => $faker->phoneNumber,
                'Description' => $faker->paragraph,
                'LocationDetail' => $faker->address,
                'IsActive' => $faker->boolean,
                'TimeCheckIn' => $faker->time,
                'TimeCheckOut' => $faker->time,
                'Type' => $faker->word,
                'StarRate' => $faker->numberBetween(1, 5),
            ]);
        }
    }
}
