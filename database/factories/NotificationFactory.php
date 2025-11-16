<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        $isRead = fake()->boolean();

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'message' => fake()->paragraph(),
            'type' => fake()->randomElement(['booking', 'reminder', 'team', 'system']),
            'is_read' => $isRead,
            'read_at' => $isRead ? now() : null,
            'date_sent' => now(),
        ];
    }
}

