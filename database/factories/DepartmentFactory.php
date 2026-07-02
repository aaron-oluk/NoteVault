<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Controlled vocabulary of realistic academic department names, paired
     * with a short code, so seeded data reads like a real university
     * catalog instead of random faker words.
     */
    protected static array $departments = [
        ['name' => 'Computer Science', 'code' => 'CS'],
        ['name' => 'Mathematics', 'code' => 'MATH'],
        ['name' => 'Physics', 'code' => 'PHYS'],
        ['name' => 'Chemistry', 'code' => 'CHEM'],
        ['name' => 'Biology', 'code' => 'BIO'],
        ['name' => 'Economics', 'code' => 'ECON'],
        ['name' => 'Psychology', 'code' => 'PSYC'],
        ['name' => 'History', 'code' => 'HIST'],
        ['name' => 'English Literature', 'code' => 'ENGL'],
        ['name' => 'Electrical Engineering', 'code' => 'EEE'],
        ['name' => 'Mechanical Engineering', 'code' => 'MECH'],
        ['name' => 'Business Administration', 'code' => 'BUS'],
        ['name' => 'Political Science', 'code' => 'POLS'],
        ['name' => 'Sociology', 'code' => 'SOC'],
        ['name' => 'Philosophy', 'code' => 'PHIL'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = fake()->randomElement(static::$departments);

        return [
            'institution_id' => Institution::factory(),
            'name' => $department['name'],
            'code' => $department['code'],
        ];
    }
}
