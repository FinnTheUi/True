<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     \App\Models\Contact::factory()->count(10)->create();
     */
    public function run(): void
    {
        \App\Models\Contact::factory()->count(10)->create();
        // Additional seeding logic can be added here if needed.
    }
}
