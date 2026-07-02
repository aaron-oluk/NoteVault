<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResearchWork>
 */
class ResearchWorkFactory extends Factory
{
    protected static array $fieldsOfStudy = [
        'Computer Science', 'Applied Mathematics', 'Physics', 'Molecular Biology',
        'Economics', 'Cognitive Psychology', 'Political Theory', 'Environmental Science',
        'Electrical Engineering', 'Public Health',
    ];

    protected static array $licenseTypes = ['all_rights_reserved', 'cc_by', 'cc_by_nc', 'cc_by_sa'];

    protected static array $statuses = ['draft', 'in_review', 'published'];

    /**
     * Define the model's default state.
     *
     * institution_id is derived from department_id in configure() below
     * (lazily created only if not overridden by the caller), so callers
     * that pass an explicit department_id never trigger an extra,
     * unrelated Department/Institution to be created. user_id defaults to
     * a lazily created researcher whose institution matches, resolved
     * after the department (and therefore institution_id) is known.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'institution_id' => null,
            'department_id' => Department::factory(),
            'user_id' => User::factory()->researcher(),
            'title' => ucfirst(fake()->sentence(6)),
            'description' => fake()->paragraphs(3, true),
            'field_of_study' => fake()->randomElement(static::$fieldsOfStudy),
            'license_type' => fake()->randomElement(static::$licenseTypes),
            'status' => fake()->randomElement(static::$statuses),
            'file_url' => null,
            'citation' => null,
            'publicly_visible' => false,
        ];
    }

    /**
     * Resolve institution_id from the department once department_id is
     * known, unless the caller already supplied an explicit institution_id.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\ResearchWork $researchWork) {
            if (empty($researchWork->institution_id) && $researchWork->department_id) {
                $researchWork->institution_id = Department::find($researchWork->department_id)?->institution_id;
            }
        });
    }

    /**
     * Attach the research work to a specific department, keeping
     * institution_id consistent with that department.
     */
    public function forDepartment(Department $department): static
    {
        return $this->state(fn (array $attributes) => [
            'institution_id' => $department->institution_id,
            'department_id' => $department->id,
        ]);
    }

    /**
     * Indicate that the research work is still a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'publicly_visible' => false,
        ]);
    }

    /**
     * Indicate that the research work is under review.
     */
    public function inReview(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_review',
            'publicly_visible' => false,
        ]);
    }

    /**
     * Indicate that the research work has been published and endorsed,
     * therefore publicly visible.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'publicly_visible' => true,
        ]);
    }
}
