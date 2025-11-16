<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'field_id' => Field::factory(),
            'image_url' => fake()->imageUrl(800, 600, 'sports', true, 'field'),
        ];
    }
}

