<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\FamilyMember
 *
 * @property int $id
 * @property int $family_id
 * @property string $first_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon $date_of_birth
 * @property string|null $relationship
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $gender
 * @property array|null $emergency_contacts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read int $age
 * @property-read Family $family
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MedicalCondition> $medicalConditions
 * @property-read int|null $medical_conditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Medication> $medications
 * @property-read int|null $medications_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereEmergencyContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereUpdatedAt($value)
 * @method static \Database\Factories\FamilyMemberFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FamilyMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'family_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'relationship',
        'email',
        'phone',
        'address',
        'gender',
        'emergency_contacts',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'emergency_contacts' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the family this member belongs to.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get all medical conditions for this family member.
     */
    public function medicalConditions(): HasMany
    {
        return $this->hasMany(MedicalCondition::class);
    }

    /**
     * Get all medications for this family member.
     */
    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the age attribute.
     */
    public function getAgeAttribute(): int
    {
        return (int) $this->date_of_birth->diffInYears(now());
    }
}