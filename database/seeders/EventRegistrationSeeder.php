<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EventRegistrationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Fetch existing IDs and event names
        $studentIds = DB::table('students')->pluck('student_id')->toArray();
        $events = DB::table('events')->select('event_id', 'event_name')->get();

        $statuses = ['Pending', 'Approved', 'Rejected', 'Cancelled', 'Completed'];

        $registrations = [];

        for ($i = 1; $i <= 1000; $i++) {
            $student_id = $faker->randomElement($studentIds);
            $event = $faker->randomElement($events);

            $registrations[] = [
                'registration_id' => $i, // Remove if auto-increment
                'student_id' => $student_id,
                'event_id' => $event->event_id,
                'event_name' => $event->event_name,
                'status' => $faker->randomElement($statuses),
            ];
        }

        foreach (array_chunk($registrations, 200) as $chunk) {
            DB::table('event_registration')->insert($chunk);
        }
    }
}
