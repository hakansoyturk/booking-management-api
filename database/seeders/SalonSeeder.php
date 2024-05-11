<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Salon;

class SalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Salon::create([
            'google_calendar_id' => '4e30d87ff2517a4ef07ca1785ab4a95285d817e566d36e6c16281fb971eec08c@group.calendar.google.com',
            'name' => 'Salon 1',
        ]);

        Salon::create([
            'google_calendar_id' => '3c8a4d6102dcd09ebc9759688d51b98b8a2e26f793af389c350ca9280b358ed3@group.calendar.google.com',
            'name' => 'Salon 2',
        ]);
    }
}
