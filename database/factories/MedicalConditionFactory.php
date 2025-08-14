<?php

namespace Database\Factories;

use App\Models\FamilyMember;
use App\Models\MedicalCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalCondition>
 */
class MedicalConditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_member_id' => FamilyMember::factory(),
            'condition_name' => $this->faker->randomElement([
                'Diabetes Type 2', 'Hypertension', 'Asthma', 'Arthritis', 
                'Heart Disease', 'Allergies', 'Migraine', 'Depression'
            ]),
            'description' => $this->faker->optional()->sentence(),
            'diagnosed_date' => $this->faker->optional()->dateTimeBetween('-10 years', 'now'),
            'severity' => $this->faker->randomElement(['mild', 'moderate', 'severe']),
            'notes' => $this->faker->optional()->paragraph(),
            'is_active' => $this->faker->boolean(85),
        ];
    }
}