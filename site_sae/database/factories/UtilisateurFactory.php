<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilisateur>
 */
class UtilisateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'pseudo' => $this->faker->userName(),
            'mail' => $this->faker->unique()->safeEmail(),
            //'mdp' => $this->faker->password(),
            'mdp' => Hash::make($this->faker->password()),
            'telephone' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'ville' => $this->faker->city(),
            'cp' => $this->faker->regexify('[0-9]{5}'),
            'role' => $this->faker->randomElement(['user']),
            'statut' => $this->faker->boolean(),
            'notif_mail' => $this->faker->boolean(),
            'statut_cotisation' => $this->faker->boolean(),
        ];
    }
}
