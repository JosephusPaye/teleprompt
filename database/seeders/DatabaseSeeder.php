<?php

namespace Database\Seeders;

use App\Models\Presentation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Presentation::factory()->create([
            'code' => 'sample',
            'title' => 'Of Mice and Men',
            'content' => file_get_contents(__DIR__ . '/of-mice-and-men.txt'),
        ]);
    }
}
