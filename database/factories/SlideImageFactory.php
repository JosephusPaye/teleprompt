<?php

namespace Database\Factories;

use App\Models\Presentation;
use App\Models\SlideImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlideImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SlideImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $index = 0;

        return [
            'presentation_id' => Presentation::factory(),
            'order' => $index,
            'thumbnail_url' => null,
            'path' => 'files/sample/slide-' . str_pad($index++ % 12, 2, '0', STR_PAD_LEFT) . '.png',
        ];
    }
}
