<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'nom' => $this->faker->word(),
            'chemin' => $this->faker->url(),
            'date_depot' => $this->faker->dateTimeThisYear(),
        ];
    }
}
