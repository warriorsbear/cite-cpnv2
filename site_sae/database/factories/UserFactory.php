<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TUtilisateur>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'cp' => fake()->regexify('[0-9]{5}'),
            'password' => static::$password ??= Hash::make('admin'),
            'remember_token' => Str::random(10),
            'statut_cotisation' => fake()->regexify('[0-1]{1}'),
            'notif_mail' => fake()->regexify('[0-1]{1}'),
            'role' => fake()->randomElement(['user']),
            'telephone' => fake()->phoneNumber(),
            'adresse' => fake()->address(),
            'pseudo' => fake()->userName(),
            'statut' => fake()->randomElement([1, 0]),
            'photo_de_profil' => 'http://127.0.0.1:8000/storage/photo_profile/avatar.jpg'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
