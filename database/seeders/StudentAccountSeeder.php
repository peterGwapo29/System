<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StudentAccountSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $accounts = [];

        for ($i = 0; $i < 1000; $i++) {
            $accounts[] = [
                'student_id' => $faker->unique()->numberBetween(1, 1000),
                'username' => $faker->unique()->userName,
                'password' => bcrypt('password'), // Secure password hashing
                'email' => $faker->unique()->safeEmail,
                'created_at' => $faker->dateTimeBetween('2024-01-01', '2025-04-26')->format('Y-m-d H:i:s'),
                'account_status' => $faker->randomElement(['Active', 'Inactive']),
            ];
        }

        DB::table('student_account')->insert($accounts);
    }
}
