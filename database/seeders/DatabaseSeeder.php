<?php

namespace Database\Seeders;

use App\Models\Presentation;
use App\Models\SlideImage;
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
        $presentation = Presentation::factory()->create([
            'code' => 'sample',
        ]);

        for ($i = 0; $i < 11; $i++) {
            SlideImage::factory()->create([
                'presentation_id' => $presentation->id,
            ]);
        }
    }
}
