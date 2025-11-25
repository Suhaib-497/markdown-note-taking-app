<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notes;
use App\Models\files;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 notes using the NotesFactory and attach 2 files per note via withFiles()
        // This ensures NotesFactory and FilesFactory are both exercised.
        \App\Models\Notes::factory()
            ->count(20)
            ->withFiles(2)
            ->create();
    }
}
