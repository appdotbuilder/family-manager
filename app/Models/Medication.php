<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Medication
 *
 * @property int $id
 * @property int $family_member_id
 * @property string $medication_name
 * @property string|null $dosage
 * @property string|null $frequency
 * @property string|null $instructions
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $prescribed_by
 * @property string|null $side_effects
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FamilyMember $familyMember
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Medication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medication query()
 * @method static \Illuminate\Database\Eloquent\Builder|Medication active()
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereFamilyMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereMedicationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication wherePrescribedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereSideEffects($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medication whereUpdatedAt($value)
 * @method static \Database\Factories\MedicationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Medication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'family_member_id',
        'medication_name',
        'dosage',
        'frequency',
        'instructions',
        'start_date',
        'end_date',
        'prescribed_by',
        'side_effects',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the family member this medication belongs to.
     */
    public function familyMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class);
    }

    /**
     * Scope a query to only include active medications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}