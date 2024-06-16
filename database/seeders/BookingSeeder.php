<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $guestIds = DB::table('guest')->pluck('id')->toArray();
        $roomIds = DB::table('room')->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
            $randomId = "BK" . $currentDateTime . rand(0, 9999);

            $RoomId = $faker->randomElement($roomIds);
            $GuestId = $faker->randomElement($guestIds);
            $TimeRecive = $faker->dateTimeBetween('-1 week', '+1 week');
            $TimeLeave = $faker->dateTimeBetween($TimeRecive, '+1 week');
            $State = $faker->numberBetween(0, 1);
            $Price = $faker->randomFloat(2, 50, 500);
            $CreateDate = now();
            $createdAt = now();

            DB::table('bookinghotel')->insert([
                'id' => $randomId,
                'RoomId' => $RoomId,
                'GuestId' => $GuestId,
                'TimeRecive' => $TimeRecive,
                'TimeLeave' => $TimeLeave,
                'State' => $State,
                'Price' => $Price,
                'CreateDate' => $CreateDate,
                'created_at' => $createdAt,
            ]);

            for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                $randomIdMember = "MB" . date("YmdHis") . substr((string)microtime(true), 2, 6) . rand(0, 9999);

                DB::table('memberbookhotel')->insert([
                    'id' => $randomIdMember,
                    'BookHotelId' => $randomId,
                    'FullName' => $faker->name,
                ]);
            }
        }
    }
}
