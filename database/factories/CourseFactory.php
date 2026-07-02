<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * institution_id is derived from department_id after the department is
     * resolved (lazily created only if not overridden by the caller), so
     * callers that pass an explicit department_id never trigger an extra,
     * unrelated Department/Institution to be created.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'institution_id' => null,
            'department_id' => Department::factory(),
            'name' => fake()->words(3, true).' course',
            'code' => strtoupper(fake()->lexify('???')).fake()->numberBetween(100, 499),
        ];
    }

    /**
     * Resolve institution_id from the department once the department_id
     * is known, unless the caller already supplied an explicit
     * institution_id.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\Course $course) {
            if (empty($course->institution_id) && $course->department_id) {
                $course->institution_id = Department::find($course->department_id)?->institution_id;
            }
        });
    }

    /**
     * Attach the course to a specific department, keeping institution_id
     * consistent with that department.
     */
    public function forDepartment(Department $department): static
    {
        return $this->state(fn (array $attributes) => [
            'institution_id' => $department->institution_id,
            'department_id' => $department->id,
        ]);
    }
}
