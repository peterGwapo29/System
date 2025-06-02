<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class StudentAccountSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $accountStatuses = ['Active', 'Inactive'];

        // Fetch existing student IDs from students table (adjust if needed)
        $studentIds = DB::table('students')->pluck('student_id')->toArray();

        $accounts = [];

        for ($i = 1; $i <= 100; $i++) {
            $studentId = $faker->randomElement($studentIds);

            $accounts[] = [
                'account_id' => $i, // Remove if auto-increment
                'student_id' => $studentId,
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password123'), // hashed password
                'email' => $faker->unique()->safeEmail,
                'created_at' => now()->toDateTimeString(), // stored as string
                'account_status' => $faker->randomElement($accountStatuses),
            ];
        }

        // Insert records in chunks to avoid memory issues
        foreach (array_chunk($accounts, 50) as $chunk) {
            DB::table('student_account')->insert($chunk);
        }
    }
}
