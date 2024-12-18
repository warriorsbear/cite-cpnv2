<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentairePost>
 */
class CommentairePostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'texte' => $this->faker->text(),
            'created_at' => $this->faker->dateTime(),
            'id_utilisateur' => $this->faker->numberBetween(1, 10),
            'id_post' => $this->faker->numberBetween(1, 10),
        ];
    }
}
