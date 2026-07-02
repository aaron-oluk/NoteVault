<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'institution_id' => Institution::factory(),
            // Most academic identities on the platform are students, per the
            // domain (CLAUDE.md), with a smaller share of lecturers,
            // researchers, and a rare admin.
            'role' => fake()->randomElement([
                ...array_fill(0, 70, 'student'),
                ...array_fill(0, 18, 'lecturer'),
                ...array_fill(0, 10, 'researcher'),
                ...array_fill(0, 2, 'admin'),
            ]),
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

    /**
     * Indicate that the user is a student.
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'student',
        ]);
    }

    /**
     * Indicate that the user is a lecturer.
     */
    public function lecturer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'lecturer',
        ]);
    }

    /**
     * Indicate that the user is a researcher.
     */
    public function researcher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'researcher',
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
