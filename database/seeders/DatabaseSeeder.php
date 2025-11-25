<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update a known test user so seeding is idempotent.
        // Use the UserFactory to generate realistic attributes, but ensure the
        // record is created or updated by email to avoid duplicates.
        $testUserData = \App\Models\User::factory()->make([
            'email' => 'test@example.com',
            'name' => 'Test User',
        ])->toArray();

        \App\Models\User::updateOrCreate(
            ['email' => 'test@example.com'],
            $testUserData
        );

        // create additional random users for development/testing
        \App\Models\User::factory()->count(9)->create();

        // Seed notes and files using factories (NotesSeeder uses Notes and Files factories)
        $this->call(NotesSeeder::class);
    }
}
