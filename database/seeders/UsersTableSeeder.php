<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            // Tạo dữ liệu giả cho bảng users
            $randomIdAccount = $faker->uuid;
            $name = $faker->name;
            $email = $faker->unique()->safeEmail;
            $password = Hash::make('password'); // Mật khẩu giả, tất cả đều giống nhau
            $telephone = $faker->phoneNumber;
            $type = $faker->randomElement(['Staff', 'Guest']);
            $createdAt = Carbon::now();

            // Chèn dữ liệu vào bảng users
            $sql = "INSERT INTO users (id, name, email, password, Telephone, Type, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            DB::insert($sql, [
                $randomIdAccount,
                $name,
                $email,
                $password,
                $telephone,
                $type,
                $createdAt
            ]);

            // Nếu loại là Staff, chèn thêm dữ liệu vào bảng staff
            if ($type === 'Staff') {
                $randomIdStaff = $faker->uuid;
                $randomcccd = $faker->numerify('##########'); // Số CCCD giả
                $sex = $faker->randomElement(['1', '2']); // 1: Nam, 2: Nữ

                $sql = "INSERT INTO staff (id, UserAccountId, Email, Telephone, Name, CCCD, Sex, Type, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                DB::insert($sql, [
                    $randomIdStaff,
                    $randomIdAccount,
                    $email,
                    $telephone,
                    $name,
                    $randomcccd,
                    $sex,
                    $type,
                    $createdAt
                ]);
            }

            if (
                $type === 'Guest'
            ) {
                $randomIdStaff = $faker->uuid;
                $randomcccd = $faker->numerify('##########'); // Số CCCD giả
                $sex = $faker->randomElement(['1', '2']); // 1: Nam, 2: Nữ

                $sql = "INSERT INTO guest (id, UserAccountId, Email, Telephone, Name, CCCD, Sex, Type, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                DB::insert($sql, [
                    $randomIdStaff,
                    $randomIdAccount,
                    $email,
                    $telephone,
                    $name,
                    $randomcccd,
                    $sex,
                    $type,
                    $createdAt
                ]);
            }
        }
    }
}
