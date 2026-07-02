<?php

namespace Database\Factories;

use App\Models\CourseUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    protected static array $types = ['notes', 'slides', 'past_paper', 'summary', 'assignment', 'lab_report'];

    protected static array $academicYears = ['2023/2024', '2024/2025', '2025/2026'];

    /**
     * Define the model's default state.
     *
     * institution_id, semester, and user_id are derived from course_unit_id
     * in configure() below (lazily created only if not overridden by the
     * caller), so callers that pass an explicit course_unit_id never
     * trigger an extra, unrelated CourseUnit chain to be created.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'institution_id' => null,
            'course_unit_id' => CourseUnit::factory(),
            'user_id' => User::factory(),
            'title' => ucfirst(fake()->words(4, true)),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(static::$types),
            'file_url' => null,
            'semester' => null,
            'academic_year' => fake()->randomElement(static::$academicYears),
            'status' => 'published',
            'approved' => true,
            // Most content on the platform is student authored, per the
            // domain, so lecturer content is a deliberately small minority.
            'is_lecturer_content' => fake()->boolean(20),
        ];
    }

    /**
     * Resolve institution_id and semester from the course unit once
     * course_unit_id is known, unless the caller already supplied explicit
     * values.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\Resource $resource) {
            if ($resource->course_unit_id && (empty($resource->institution_id) || empty($resource->semester))) {
                $courseUnit = CourseUnit::find($resource->course_unit_id);

                if ($courseUnit) {
                    $resource->institution_id ??= $courseUnit->institution_id;
                    $resource->semester ??= $courseUnit->semester;
                }
            }
        });
    }

    /**
     * Attach the resource to a specific course unit, keeping
     * institution_id consistent with that course unit.
     */
    public function forCourseUnit(CourseUnit $courseUnit): static
    {
        return $this->state(fn (array $attributes) => [
            'institution_id' => $courseUnit->institution_id,
            'course_unit_id' => $courseUnit->id,
            'semester' => $courseUnit->semester,
        ]);
    }

    /**
     * Indicate that the resource is authoritative lecturer content.
     */
    public function lecturerContent(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_lecturer_content' => true,
        ]);
    }
}
