<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseUnit>
 */
class CourseUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * institution_id is derived from course_id after the course is
     * resolved (lazily created only if not overridden by the caller), so
     * callers that pass an explicit course_id never trigger an extra,
     * unrelated Course/Department/Institution chain to be created.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'institution_id' => null,
            'course_id' => Course::factory(),
            'name' => fake()->words(2, true).' unit',
            'code' => strtoupper(fake()->lexify('??')).fake()->numberBetween(1000, 4999),
            'semester' => fake()->randomElement(['Semester 1', 'Semester 2', 'Full Year']),
        ];
    }

    /**
     * Resolve institution_id from the course once the course_id is known,
     * unless the caller already supplied an explicit institution_id.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\CourseUnit $courseUnit) {
            if (empty($courseUnit->institution_id) && $courseUnit->course_id) {
                $courseUnit->institution_id = Course::find($courseUnit->course_id)?->institution_id;
            }
        });
    }

    /**
     * Attach the course unit to a specific course, keeping institution_id
     * consistent with that course.
     */
    public function forCourse(Course $course): static
    {
        return $this->state(fn (array $attributes) => [
            'institution_id' => $course->institution_id,
            'course_id' => $course->id,
        ]);
    }
}
