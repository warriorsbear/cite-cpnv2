<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visionnage>
 */
class VisionnageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_evenement' => $this->faker->unique()->numberBetween(1, 10),
            'date_visibilite' => $this->faker->dateTimeThisYear(),
            'date_diffusion' => $this->faker->dateTimeThisYear(),
        ];
    }
}
