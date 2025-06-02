<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MembershipsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['Active', 'Inactive'];
        $types = ['regular', 'associate', 'honorary'];

        // Get existing student and club names
        $studentIds = DB::table('students')->pluck('student_id')->toArray();
        $clubNames = DB::table('clubs')->pluck('club_name')->toArray();

        $memberships = [];

        for ($i = 1; $i <= 1000; $i++) {
            $memberships[] = [
                'membership_id' => $i, // Remove if auto-increment
                'membership_type' => $faker->randomElement($types),
                'student_id' => $faker->randomElement($studentIds),
                'club_name' => $faker->randomElement($clubNames),
                'status' => $faker->randomElement($statuses),
            ];
        }

        foreach (array_chunk($memberships, 200) as $chunk) {
            DB::table('memberships')->insert($chunk);
        }
    }
}
