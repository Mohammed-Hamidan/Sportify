<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\District;
use App\Models\Field;
use App\Models\FieldAvailability;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\Sport;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $sportNames = ['Football', 'Padel', 'Basketball', 'Tennis', 'Volleyball'];
        $districtNames = ['Downtown', 'Uptown', 'East Side', 'West End', 'Harbor'];

        $sports = collect($sportNames)->map(fn ($name) => Sport::factory()->create(['sport_name' => $name]));
        $districts = collect($districtNames)->map(fn ($name) => District::factory()->create(['district_name' => $name]));

        $admin = User::factory()->create([
            'name' => 'Sportify Admin',
            'username' => 'sportify_admin',
            'email' => 'admin@sportify.test',
            'phone' => '+10000000000',
            'role' => 'admin',
        ]);

        $owners = User::factory()->count(5)->state(fn () => [
            'role' => 'owner',
        ])->create();

        $players = User::factory()->count(20)->state(fn () => [
            'role' => 'player',
        ])->create();

        $fields = new Collection();

        $owners->each(function (User $owner) use (&$fields, $sports, $districts) {
            $ownerFields = Field::factory()
                ->count(2)
                ->state(fn () => [
                    'owner_id' => $owner->id,
                    'sport_id' => $sports->random()->id,
                    'district_id' => $districts->random()->id,
                ])
                ->hasImages(3)
                ->create();

            $fields = $fields->merge($ownerFields);

            $ownerFields->each(function (Field $field) {
                for ($day = 1; $day <= 2; $day++) {
                    for ($hour = 8; $hour <= 12; $hour++) {
                        FieldAvailability::factory()->create([
                            'field_id' => $field->id,
                            'date' => now()->addDays($day)->toDateString(),
                            'start_time' => sprintf('%02d:00:00', $hour),
                            'end_time' => sprintf('%02d:00:00', $hour + 1),
                        ]);
                    }
                }
            });
        });

        $teams = Team::factory()->count(4)->state(fn () use ($sports, $players) {
            $captain = $players->random();

            return [
                'captain_id' => $captain->id,
                'sport_id' => $sports->random()->id,
            ];
        })->create();

        $teams->each(function (Team $team) use ($players) {
            $memberIds = $players->shuffle()->take(6)->pluck('id');

            $memberIds->each(function ($playerId) use ($team) {
                TeamMember::factory()->create([
                    'team_id' => $team->id,
                    'user_id' => $playerId,
                ]);
            });

            if (! $memberIds->contains($team->captain_id)) {
                TeamMember::factory()->create([
                    'team_id' => $team->id,
                    'user_id' => $team->captain_id,
                ]);
            }
        });

        $fields->each(function (Field $field) use ($players, $teams) {
            Booking::factory()->count(3)->state(function () use ($field, $players, $teams) {
                return [
                    'field_id' => $field->id,
                    'player_id' => $players->random()->id,
                    'team_id' => $teams->random()->id,
                    'total_price' => $field->price_per_hour,
                ];
            })->create();

            $players->shuffle()->take(4)->each(function (User $player) use ($field) {
                Rating::factory()->create([
                    'field_id' => $field->id,
                    'user_id' => $player->id,
                ]);
            });
        });

        Notification::factory()->count(20)->state(fn () => [
            'user_id' => $players->random()->id,
        ])->create();
    }
}
