<?php

namespace Database\Factories;

use App\Models\Sport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'team_name' => fake()->unique()->company() . ' FC',
            'captain_id' => User::factory()->state(['role' => 'player']),
            'sport_id' => Sport::factory(),
        ];
    }
}

