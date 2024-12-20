<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Photo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idUser = $this->faker->numberBetween(1, 10);
        return [
            'nom' => $this->faker->word,
            'nom_min' => $this->faker->word,
            'date_prise_vue' => $this->faker->dateTime(),
            'date_depot' => $this->faker->dateTime(),
            'legende' => $this->faker->text,
            'id_utilisateur' => $idUser,
            'id_utilisateur_1' => $idUser,
            'id_post' => $this->faker->numberBetween(1, 10),
        ];
    }
}
