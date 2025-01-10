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
            'legende' => $this->faker->text,
            'id_utilisateur' => $idUser,
            'id_utilisateur_1' => $idUser,
            'id_post' => $this->faker->numberBetween(1, 10),
            'exif1' => ['Sony Alpha 7R IV', 'Canon EOS 5D Mark IV', 'Nikon D850'][$this->faker->numberBetween(0, 2)],
            'exif2' => ['FE 24-70mm F2.8 GM', 'EF 70-200mm f/2.8L IS II USM', 'AF-S NIKKOR 70-200mm f/2.8E FL ED VR'][$this->faker->numberBetween(0, 2)],
            'exif3' => ['70mm', '200mm', '24mm'][$this->faker->numberBetween(0, 2)],
            'exif4' => ['f/2.8', 'f/3.5', 'f/8'][$this->faker->numberBetween(0, 2)],
            'exif5' => ['1/200s', '1/1000s', '1/500s'][$this->faker->numberBetween(0, 2)],
            'exif6' => ['ISO 100', 'ISO 400', 'ISO 800'][$this->faker->numberBetween(0, 2)],
        ];
    }
}
