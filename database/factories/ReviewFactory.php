<?php

namespace Database\Factories;

use App\Models\ResearchWork;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected static array $statuses = ['pending', 'approved', 'changes_requested', 'rejected'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'research_work_id' => ResearchWork::factory(),
            'reviewer_id' => User::factory()->researcher(),
            'status' => fake()->randomElement(static::$statuses),
            'comments' => fake()->paragraph(),
            'blind_review' => fake()->boolean(30),
        ];
    }

    /**
     * Attach the review to a specific research work, written by a
     * specific reviewer.
     */
    public function forResearchWork(ResearchWork $researchWork, User $reviewer): static
    {
        return $this->state(fn (array $attributes) => [
            'research_work_id' => $researchWork->id,
            'reviewer_id' => $reviewer->id,
        ]);
    }

    /**
     * Indicate that the review approved the research work.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }
}
