<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentairePhoto>
 */
class CommentairePhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'texte' => $this->faker->text(50),
            'date_heure' => $this->faker->dateTime(),
            'id_utilisateur' => $this->faker->numberBetween(1, 10),
            'id_photo' => $this->faker->numberBetween(1, 10),
        ];
    }
}
