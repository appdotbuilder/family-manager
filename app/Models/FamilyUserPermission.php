<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FamilyUserPermission
 *
 * @property int $id
 * @property int $family_id
 * @property int $user_id
 * @property string $role
 * @property array|null $permissions
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $invited_at
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Family $family
 * @property-read User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission active()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereInvitedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyUserPermission whereUserId($value)
 * @method static \Database\Factories\FamilyUserPermissionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FamilyUserPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'family_id',
        'user_id',
        'role',
        'permissions',
        'is_active',
        'invited_at',
        'accepted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
        'invited_at' => 'datetime',
        'accepted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the family this permission belongs to.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get the user this permission belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active permissions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if the user can edit family members.
     */
    public function canEditMembers(): bool
    {
        return in_array($this->role, ['owner', 'admin', 'editor']);
    }

    /**
     * Check if the user can view medical information.
     */
    public function canViewMedicalInfo(): bool
    {
        return in_array($this->role, ['owner', 'admin', 'editor']);
    }

    /**
     * Check if the user can edit medical information.
     */
    public function canEditMedicalInfo(): bool
    {
        return in_array($this->role, ['owner', 'admin', 'editor']);
    }
}