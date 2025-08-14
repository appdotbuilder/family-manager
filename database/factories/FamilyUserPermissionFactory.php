<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\FamilyUserPermission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyUserPermission>
 */
class FamilyUserPermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'user_id' => User::factory(),
            'role' => $this->faker->randomElement(['owner', 'admin', 'editor', 'viewer']),
            'permissions' => null,
            'is_active' => $this->faker->boolean(90),
            'invited_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'accepted_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}