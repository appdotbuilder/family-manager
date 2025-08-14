<?php

namespace Database\Factories;

use App\Models\FamilyMember;
use App\Models\Medication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medication>
 */
class MedicationFactory extends Factory
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
            'medication_name' => $this->faker->randomElement([
                'Metformin', 'Lisinopril', 'Albuterol', 'Ibuprofen', 
                'Omeprazole', 'Simvastatin', 'Amlodipine', 'Sertraline'
            ]),
            'dosage' => $this->faker->randomElement(['5mg', '10mg', '25mg', '50mg', '100mg', '500mg']),
            'frequency' => $this->faker->randomElement([
                'Once daily', 'Twice daily', 'Three times daily', 
                'Every 8 hours', 'As needed', 'Before meals'
            ]),
            'instructions' => $this->faker->optional()->sentence(),
            'start_date' => $this->faker->optional()->dateTimeBetween('-2 years', 'now'),
            'end_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'prescribed_by' => $this->faker->optional()->name('Dr.'),
            'side_effects' => $this->faker->optional()->sentence(),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}