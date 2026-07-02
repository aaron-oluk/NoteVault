<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * A starter controlled vocabulary of realistic academic tags, grouped
     * by category, rather than random faker words. DatabaseSeeder seeds
     * from this same list directly; this factory exists mainly so ad hoc
     * factory usage (tests, tinker) still produces plausible tags.
     */
    public static array $vocabulary = [
        'topic' => [
            'Algorithms', 'Data Structures', 'Linear Algebra', 'Calculus',
            'Thermodynamics', 'Organic Chemistry', 'Genetics', 'Microeconomics',
            'Macroeconomics', 'Statistics', 'Machine Learning', 'Database Systems',
            'Operating Systems', 'Cell Biology', 'Quantum Mechanics',
        ],
        'material_type' => [
            'Exam Prep', 'Lecture Notes', 'Lab Guide', 'Cheat Sheet',
            'Worked Examples', 'Revision Summary',
        ],
    ];

    /**
     * Track which vocabulary entries have already been used so repeated
     * factory calls do not collide with the unique name constraint.
     */
    protected static array $used = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = fake()->randomElement(array_keys(static::$vocabulary));
        $available = array_diff(static::$vocabulary[$category], static::$used);

        if (empty($available)) {
            static::$used = [];
            $available = static::$vocabulary[$category];
        }

        $name = fake()->randomElement($available);
        static::$used[] = $name;

        return [
            'name' => $name,
            'category' => $category,
        ];
    }
}
