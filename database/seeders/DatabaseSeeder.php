<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\Department;
use App\Models\Endorsement;
use App\Models\Institution;
use App\Models\Resource;
use App\Models\ResourceVersion;
use App\Models\ResearchWork;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Database\Factories\TagFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Dependency order: Institution -> Department -> Course -> CourseUnit
     * -> User -> Tag -> Resource (+ ResourceVersion for lecturer content)
     * -> ResearchWork (+ Review/Endorsement for a subset), keeping every
     * row's institution scoping internally consistent per the plan.
     */
    public function run(): void
    {
        // Default institution first, then the admin user tied to it. This
        // replaces the raw admin insert that used to live in the users
        // migration; institutions could not exist at that point since the
        // users migration is pinned to the earliest possible timestamp.
        $defaultInstitution = Institution::factory()->create([
            'name' => 'NoteVault University',
            'email_domain' => 'admin.com',
        ]);

        User::factory()->admin()->create([
            'first_name' => 'Aaron',
            'last_name' => 'Leon',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'institution_id' => $defaultInstitution->id,
        ]);

        // A small handful of realistic universities.
        $institutions = collect([
            ['name' => 'Riverside State University', 'email_domain' => 'riverside.edu'],
            ['name' => 'Lakeshore Institute of Technology', 'email_domain' => 'lakeshoretech.edu'],
            ['name' => 'Ashford University', 'email_domain' => 'ashford.edu'],
            ['name' => 'Grantham College', 'email_domain' => 'grantham.edu'],
        ])->map(fn (array $attributes) => Institution::factory()->create($attributes));

        $departmentNames = [
            ['name' => 'Computer Science', 'code' => 'CS'],
            ['name' => 'Mathematics', 'code' => 'MATH'],
            ['name' => 'Physics', 'code' => 'PHYS'],
            ['name' => 'Economics', 'code' => 'ECON'],
            ['name' => 'Psychology', 'code' => 'PSYC'],
        ];

        $courseUnits = collect();

        foreach ($institutions as $institution) {
            // A few departments per institution.
            $departments = collect($departmentNames)
                ->random(3)
                ->values()
                ->map(fn (array $attrs) => Department::factory()->create([
                    'institution_id' => $institution->id,
                    'name' => $attrs['name'],
                    'code' => $attrs['code'],
                ]));

            foreach ($departments as $department) {
                // A few courses per department.
                $courses = Course::factory()
                    ->count(fake()->numberBetween(2, 3))
                    ->create([
                        'institution_id' => $institution->id,
                        'department_id' => $department->id,
                    ]);

                foreach ($courses as $course) {
                    // A few course units per course.
                    $units = CourseUnit::factory()
                        ->count(fake()->numberBetween(2, 4))
                        ->create([
                            'institution_id' => $institution->id,
                            'course_id' => $course->id,
                        ]);

                    $courseUnits = $courseUnits->concat($units);
                }
            }
        }

        // Users varied across roles and institutions, weighted mostly
        // student per UserFactory's default role distribution.
        $usersByInstitution = $institutions->mapWithKeys(function (Institution $institution) {
            $users = User::factory()
                ->count(fake()->numberBetween(15, 25))
                ->create(['institution_id' => $institution->id]);

            return [$institution->id => $users];
        });

        // Make sure every institution has at least a couple of lecturers
        // and a researcher available to author lecturer content, review,
        // and supervise, even if the random role draw came up short.
        foreach ($institutions as $institution) {
            $users = $usersByInstitution[$institution->id];

            if ($users->where('role', 'lecturer')->isEmpty()) {
                $users->push(User::factory()->lecturer()->create(['institution_id' => $institution->id]));
            }

            if ($users->where('role', 'researcher')->isEmpty()) {
                $users->push(User::factory()->researcher()->create(['institution_id' => $institution->id]));
            }

            $usersByInstitution[$institution->id] = $users;
        }

        // Starter controlled vocabulary of tags across a couple of
        // categories.
        $tags = collect();
        foreach (TagFactory::$vocabulary as $category => $names) {
            foreach ($names as $name) {
                $tags->push(Tag::create(['name' => $name, 'category' => $category]));
            }
        }

        // Resources per course unit, mostly student authored with a
        // minority of lecturer content.
        foreach ($courseUnits as $courseUnit) {
            $institutionUsers = $usersByInstitution[$courseUnit->institution_id];
            $lecturers = $institutionUsers->where('role', 'lecturer');
            $students = $institutionUsers->reject(fn (User $user) => $user->role === 'admin');

            $resourceCount = fake()->numberBetween(3, 6);

            for ($i = 0; $i < $resourceCount; $i++) {
                $isLecturerContent = $lecturers->isNotEmpty() && fake()->boolean(20);
                $author = $isLecturerContent ? $lecturers->random() : $students->random();

                $resource = Resource::factory()
                    ->forCourseUnit($courseUnit)
                    ->state(['is_lecturer_content' => $isLecturerContent])
                    ->create(['user_id' => $author->id]);

                // Tag a portion of resources with a couple of seeded tags.
                if (fake()->boolean(60)) {
                    $resource->tags()->attach($tags->random(fake()->numberBetween(1, 3))->pluck('id'));
                }

                // ResourceVersion rows are only meaningfully used for
                // resources where is_lecturer_content is true.
                if ($isLecturerContent) {
                    $versionCount = fake()->numberBetween(2, 4);

                    for ($v = 1; $v <= $versionCount; $v++) {
                        ResourceVersion::factory()
                            ->forResource($resource, $author, $v)
                            ->create();
                    }
                }
            }
        }

        // ResearchWork, authored by users with role researcher, varied
        // status values.
        $reviewStatuses = ['draft', 'in_review', 'in_review', 'published', 'published'];

        foreach ($institutions as $institution) {
            $institutionUsers = $usersByInstitution[$institution->id];
            $researchers = $institutionUsers->where('role', 'researcher');
            $lecturers = $institutionUsers->where('role', 'lecturer');

            if ($researchers->isEmpty()) {
                continue;
            }

            $departments = Department::where('institution_id', $institution->id)->get();

            if ($departments->isEmpty()) {
                continue;
            }

            $researchWorkCount = fake()->numberBetween(3, 5);

            for ($i = 0; $i < $researchWorkCount; $i++) {
                $department = $departments->random();
                $status = fake()->randomElement($reviewStatuses);

                $researchWork = ResearchWork::factory()
                    ->forDepartment($department)
                    ->state(['status' => $status, 'publicly_visible' => false])
                    ->create(['user_id' => $researchers->random()->id]);

                if (fake()->boolean(60)) {
                    $researchWork->tags()->attach($tags->random(fake()->numberBetween(1, 2))->pluck('id'));
                }

                // Review and Endorsement for a subset of in_review/published
                // research works, tied to reviewer_id/supervisor_id users.
                if (in_array($status, ['in_review', 'published'], true)) {
                    $reviewer = $researchers->random();

                    Review::factory()
                        ->forResearchWork($researchWork, $reviewer)
                        ->state(['status' => $status === 'published' ? 'approved' : 'pending'])
                        ->create();

                    if ($lecturers->isNotEmpty()) {
                        $supervisor = $lecturers->random();
                        $endorsementStatus = $status === 'published' ? 'endorsed' : 'pending';

                        Endorsement::factory()
                            ->forResearchWork($researchWork, $supervisor)
                            ->state(['status' => $endorsementStatus])
                            ->create();

                        // Replicate EndorsementController::store()'s side
                        // effect: an endorsed status flips the parent
                        // ResearchWork's publicly_visible flag to true.
                        if ($endorsementStatus === 'endorsed') {
                            $researchWork->update(['publicly_visible' => true]);
                        }
                    }
                }
            }
        }
    }
}
