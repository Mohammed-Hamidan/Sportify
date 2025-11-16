<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\FieldAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FieldAvailability>
 */
class FieldAvailabilityFactory extends Factory
{
    protected $model = FieldAvailability::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 day', '+2 days');
        $end = (clone $start)->modify('+1 hour');

        return [
            'field_id' => Field::factory(),
            'date' => $start->format('Y-m-d'),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'is_booked' => false,
        ];
    }
}

