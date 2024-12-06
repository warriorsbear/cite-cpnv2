<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participation>
 */
class ParticipationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_utilisateur' => $this->faker->numberBetween(1, 10),
            'id_evenement' => $this->faker->numberBetween(1, 10),
            'presence' => $this->faker->boolean(),
        ];
    }
}
