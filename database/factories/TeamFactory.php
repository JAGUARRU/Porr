<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        $currentTeamId = User::count() + 1;

        return [
            'user_id' => $currentTeamId,
            'name' => $this->faker->name . '\'s team',
            'personal_team' => true,
        ];
    }
}
