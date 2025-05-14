<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 1; $i <= 1000; $i++) {
            $data[] = [
                'account_id' => $i,
                'student_id' => $i,
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password123'),
                'email' => $faker->unique()->safeEmail,
                'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
            ];
        }

        DB::table('student_account')->insert($data);
    }
}
