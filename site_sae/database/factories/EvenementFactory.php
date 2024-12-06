<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evenement>
 */
class EvenementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_heure' => $this->faker->dateTime(),
            'titre' => $this->faker->text(50),
            'descriptif' => $this->faker->text(200),
            'lieu' => $this->faker->city(),
            'type' => $this->faker->randomElement(['collaboration','cours','exposition','information','reunion','sortie_a_theme','visionnage']),
            'officiel' => $this->faker->boolean(),
            'id_utilisateur' => $this->faker->numberBetween(1, 10),
        ];
    }
}

