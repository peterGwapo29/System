<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        $courses = ['BSIT', 'BTLED', 'BSA', 'BSBA'];
        $statuses = ['Active', 'Inactive'];

        for ($i = 1; $i <= 1000; $i++) {
            $data[] = [
                'student_id' => $i,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'middle_name' => $faker->firstName,
                'course' => $faker->randomElement($courses),
                'year_level' => $faker->numberBetween(1, 4),
                'status' => $faker->randomElement($statuses),
            ];
        }

        DB::table('students')->insert($data);
    }
}
