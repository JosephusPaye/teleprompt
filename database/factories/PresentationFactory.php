<?php

namespace Database\Factories;

use App\Models\Presentation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PresentationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Presentation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'code' => Str::random(8),
            'content' => $this->faker->paragraphs(),
            'settings' => json_encode([
                'mirrorVertically' => $this->faker->boolean(),
                'mirrorHorizontally' => $this->faker->boolean(),
                'textSize' => 1,
            ])
        ];
    }
}
