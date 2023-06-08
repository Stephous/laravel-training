<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => 'client',
        ];
    }

    public function expiredToken(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'authentication_token' => 'test1',
                'authentication_token_generated_at' => now()->subHours(25),
            ];
        });
    }

    public function createValidToken(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'authentication_token' => 'test1',
                'authentication_token_generated_at' => now(),
            ];
        });
    }
}
