<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyMember>
 */
class FamilyMemberFactory extends Factory
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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-1 years'),
            'relationship' => $this->faker->randomElement(['parent', 'child', 'sibling', 'spouse', 'grandparent', 'grandchild']),
            'email' => $this->faker->optional(0.7)->email(),
            'phone' => $this->faker->optional(0.8)->phoneNumber(),
            'address' => $this->faker->optional(0.6)->address(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other', 'prefer_not_to_say']),
            'emergency_contacts' => $this->faker->optional(0.5)->randomElements([
                [
                    'name' => $this->faker->name(),
                    'phone' => $this->faker->phoneNumber(),
                    'relationship' => $this->faker->randomElement(['spouse', 'parent', 'sibling', 'friend']),
                ]
            ], 1),
        ];
    }
}