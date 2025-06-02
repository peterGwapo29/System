<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClubsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['Active', 'Inactive'];
        $data = [];

        for ($i = 1; $i <= 1000; $i++) {
            $data[] = [
                'club_id' => $i, // Remove if using auto-increment
                'club_name' => $faker->unique()->words(3, true) . ' Club',
                'club_description' => $faker->paragraph,
                'adviser_name' => $faker->name,
                'status' => $faker->randomElement($statuses),
            ];
        }

        // Chunk insert to prevent memory or packet errors
        foreach (array_chunk($data, 200) as $chunk) {
            DB::table('clubs')->insert($chunk);
        }
    }
}
