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
                'password' => bcrypt('password'), // Use bcrypt for password hashing
                'email' => $faker->unique()->safeEmail,
                'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'), // Format timestamp properly
                'account_status' => $faker->randomElement(['active']),
            ];
        }

        // Insert all records at once for better performance
        DB::table('student_account')->insert($accounts);
    }
}
