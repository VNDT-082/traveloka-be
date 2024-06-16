<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TyperoomSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $hotels = DB::table('hotel')->pluck('id');

        foreach ($hotels as $HotelId) {
            for ($i = 0; $i < 3; $i++) {
                $currentDateTime = date("YmdHis") . $i;
                $randomIdTyperoom = "TR" . $currentDateTime . rand(0, 99999);

                DB::table('typeroom')->insert([
                    'id' => $randomIdTyperoom,
                    'HotelId' => $HotelId,
                    'Name' => $faker->word,
                    'ConvenientRoom' => $faker->sentence,
                    'ConvenientBathRoom' => $faker->sentence,
                    'FloorArea' => $faker->numberBetween(20, 100),
                    'MaxQuantityMember' => $faker->numberBetween(1, 10),
                    'Price' => $faker->numberBetween(50, 500),
                    'Voi_Tam_Dung' => $faker->boolean,
                    'Ban_Cong_San_Hien' => $faker->boolean,
                    'Khu_Vuc_Cho' => $faker->boolean,
                    'May_Lanh' => $faker->boolean,
                    'Nuoc_Nong' => $faker->boolean,
                    'Bon_Tam' => $faker->boolean,
                    'TenLoaiGiuong' => $faker->word,
                    'SoLuongGiuong' => $faker->numberBetween(1, 4),
                    'Lo_Vi_Song' => $faker->boolean,
                    'Tu_Lanh' => $faker->boolean,
                    'May_Giat' => $faker->boolean,
                    'No_Moking' => $faker->boolean,
                ]);
            }
        }
    }
}
