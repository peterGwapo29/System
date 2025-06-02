<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['Active', 'Inactive'];

        $data = [];

        for ($i = 1; $i <= 1000; $i++) {
            $data[] = [
                'event_id' => $i, // Optional: remove if auto-increment
                'club_id' => $faker->numberBetween(1, 50), // Adjust based on existing club IDs
                'event_name' => $faker->sentence(3),
                'event_date' => $faker->date('Y-m-d H:i:s'),
                'venue' => $faker->company . ' Convention Center',
                'event_description' => $faker->paragraph,
                'status' => $faker->randomElement($statuses),
            ];
        }

        DB::table('events')->insert($data);
    }
}
