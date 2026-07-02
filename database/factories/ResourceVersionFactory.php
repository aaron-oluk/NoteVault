<?php

namespace Database\Factories;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResourceVersion>
 */
class ResourceVersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Meaningfully used only for resources where is_lecturer_content is
     * true, since student content is peer driven and not versioned in the
     * same authoritative way. resource_id defaults to a lazily created
     * lecturer content Resource so a bare ResourceVersion::factory()->create()
     * still produces a sensible row, but user_id is derived from that
     * resource's user_id only when not overridden by the caller.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resource_id' => Resource::factory()->lecturerContent(),
            'user_id' => null,
            'version_number' => 1,
            'changelog' => fake()->sentence(),
            'file_url' => null,
        ];
    }

    /**
     * Resolve user_id from the resource's author once resource_id is
     * known, unless the caller already supplied an explicit user_id.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\ResourceVersion $resourceVersion) {
            if (empty($resourceVersion->user_id) && $resourceVersion->resource_id) {
                $resourceVersion->user_id = Resource::find($resourceVersion->resource_id)?->user_id;
            }
        });
    }

    /**
     * Attach the version to a specific resource, authored by a specific
     * user, at a specific version number.
     */
    public function forResource(Resource $resource, User $user, int $versionNumber): static
    {
        return $this->state(fn (array $attributes) => [
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'version_number' => $versionNumber,
        ]);
    }
}
