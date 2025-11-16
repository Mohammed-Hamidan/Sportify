<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Field;
use App\Models\Sport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Field>
 */
class FieldFactory extends Factory
{
    protected $model = Field::class;

    public function definition(): array
    {
        $opening = fake()->time('H:00');
        $closing = fake()->time('H:00');

        if ($closing <= $opening) {
            $closing = date('H:00', strtotime($opening) + 4 * 3600);
        }

        return [
            'owner_id' => User::factory()->state(['role' => 'owner']),
            'sport_id' => Sport::factory(),
            'district_id' => District::factory(),
            'name' => fake()->company() . ' Field',
            'price_per_hour' => fake()->randomFloat(2, 20, 200),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'rating' => fake()->randomFloat(2, 3, 5),
            'opening_time' => $opening,
            'closing_time' => $closing,
            'is_available' => true,
        ];
    }
}

