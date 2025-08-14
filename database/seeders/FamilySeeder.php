<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\MedicalCondition;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user if one doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Create a family
        $family = Family::create([
            'name' => 'The Smith Family',
            'description' => 'A loving family with diverse backgrounds and interests.',
            'created_by' => $user->id,
        ]);

        // Add the user as the family owner
        $family->users()->attach($user->id, [
            'role' => 'owner',
            'is_active' => true,
            'accepted_at' => now(),
        ]);

        // Create family members
        $members = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'date_of_birth' => now()->subYears(45)->toDateString(),
                'relationship' => 'parent',
                'email' => 'john.smith@example.com',
                'phone' => '+1 (555) 123-4567',
                'gender' => 'male',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Smith',
                'date_of_birth' => now()->subYears(42)->toDateString(),
                'relationship' => 'parent',
                'email' => 'sarah.smith@example.com',
                'phone' => '+1 (555) 123-4568',
                'gender' => 'female',
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Smith',
                'date_of_birth' => now()->subYears(16)->toDateString(),
                'relationship' => 'child',
                'email' => 'emma.smith@example.com',
                'phone' => '+1 (555) 123-4569',
                'gender' => 'female',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Smith',
                'date_of_birth' => now()->subYears(14)->toDateString(),
                'relationship' => 'child',
                'phone' => '+1 (555) 123-4570',
                'gender' => 'male',
            ]
        ];

        foreach ($members as $memberData) {
            /** @var \App\Models\FamilyMember $member */
            $member = $family->members()->create($memberData);

            // Add some medical conditions
            if ($memberData['first_name'] === 'John') {
                $member->medicalConditions()->create([
                    'condition_name' => 'Type 2 Diabetes',
                    'description' => 'Managed with diet and medication',
                    'diagnosed_date' => now()->subYears(5)->toDateString(),
                    'severity' => 'moderate',
                    'is_active' => true,
                ]);

                $member->medications()->create([
                    'medication_name' => 'Metformin',
                    'dosage' => '500mg',
                    'frequency' => 'Twice daily',
                    'start_date' => now()->subYears(5)->toDateString(),
                    'prescribed_by' => 'Dr. Johnson',
                    'is_active' => true,
                ]);
            }

            if ($memberData['first_name'] === 'Emma') {
                $member->medicalConditions()->create([
                    'condition_name' => 'Asthma',
                    'description' => 'Exercise-induced asthma',
                    'diagnosed_date' => now()->subYears(8)->toDateString(),
                    'severity' => 'mild',
                    'is_active' => true,
                ]);

                $member->medications()->create([
                    'medication_name' => 'Albuterol Inhaler',
                    'dosage' => '90mcg',
                    'frequency' => 'As needed',
                    'start_date' => now()->subYears(8)->toDateString(),
                    'prescribed_by' => 'Dr. Williams',
                    'is_active' => true,
                ]);
            }
        }
    }
}