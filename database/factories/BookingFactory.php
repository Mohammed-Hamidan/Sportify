<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $field = Field::factory();
        $player = User::factory()->state(['role' => 'player']);
        $teamFactory = Team::factory();

        $start = fake()->dateTimeBetween('+1 day', '+1 week');
        $end = (clone $start)->modify('+1 hour');

        return [
            'field_id' => $field,
            'player_id' => $player,
            'team_id' => fake()->boolean(30) ? $teamFactory : null,
            'date' => $start->format('Y-m-d'),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'total_price' => fake()->randomFloat(2, 20, 200),
            'payment_method' => 'cash',
            'status' => fake()->randomElement(['confirmed', 'canceled', 'pending']),
        ];
    }
}

