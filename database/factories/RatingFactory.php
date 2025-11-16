<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rating>
 */
class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'field_id' => Field::factory(),
            'user_id' => User::factory()->state(['role' => 'player']),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}

