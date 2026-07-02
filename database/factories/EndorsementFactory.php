<?php

namespace Database\Factories;

use App\Models\ResearchWork;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endorsement>
 */
class EndorsementFactory extends Factory
{
    protected static array $statuses = ['pending', 'endorsed', 'rejected'];

    /**
     * Define the model's default state.
     *
     * Note: this factory only fills the endorsement row itself. It does not
     * flip the parent ResearchWork's publicly_visible flag, since that side
     * effect lives in EndorsementController::store(). Seeders that want the
     * real end to end behavior should set publicly_visible on the
     * ResearchWork explicitly when creating an endorsed row.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(static::$statuses);

        return [
            'research_work_id' => ResearchWork::factory(),
            'supervisor_id' => User::factory()->lecturer(),
            'status' => $status,
            'notes' => fake()->optional()->sentence(),
            'endorsed_at' => $status === 'endorsed' ? now() : null,
        ];
    }

    /**
     * Attach the endorsement to a specific research work, given by a
     * specific supervisor.
     */
    public function forResearchWork(ResearchWork $researchWork, User $supervisor): static
    {
        return $this->state(fn (array $attributes) => [
            'research_work_id' => $researchWork->id,
            'supervisor_id' => $supervisor->id,
        ]);
    }

    /**
     * Indicate that the supervisor endorsed the research work.
     */
    public function endorsed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'endorsed',
            'endorsed_at' => now(),
        ]);
    }
}
