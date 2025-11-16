<?php

namespace Database\Factories;

use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sport>
 */
class SportFactory extends Factory
{
    protected $model = Sport::class;

    public function definition(): array
    {
        $sports = ['Football', 'Padel', 'Basketball', 'Tennis', 'Volleyball'];

        return [
            'sport_name' => fake()->unique()->randomElement($sports),
        ];
    }
}

