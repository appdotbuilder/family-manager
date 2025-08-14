<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MedicalCondition
 *
 * @property int $id
 * @property int $family_member_id
 * @property string $condition_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $diagnosed_date
 * @property string|null $severity
 * @property string|null $notes
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FamilyMember $familyMember
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition active()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereConditionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereDiagnosedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereFamilyMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalCondition whereUpdatedAt($value)
 * @method static \Database\Factories\MedicalConditionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class MedicalCondition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'family_member_id',
        'condition_name',
        'description',
        'diagnosed_date',
        'severity',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'diagnosed_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the family member this condition belongs to.
     */
    public function familyMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class);
    }

    /**
     * Scope a query to only include active conditions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}