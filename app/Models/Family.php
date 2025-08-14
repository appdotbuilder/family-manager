<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Family
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FamilyMember> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Family newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Family newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Family query()
 * @method static \Illuminate\Database\Eloquent\Builder|Family whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Family whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Family whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Family whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Family whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Family whereUpdatedAt($value)
 * @method static \Database\Factories\FamilyFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Family extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this family.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all family members.
     */
    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    /**
     * Get all users with access to this family.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'family_user_permissions')
            ->withPivot(['role', 'permissions', 'is_active', 'invited_at', 'accepted_at'])
            ->withTimestamps();
    }

    /**
     * Check if a user has access to this family.
     */
    public function hasUserAccess(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->where('is_active', true)->exists();
    }

    /**
     * Get user's role in this family.
     */
    public function getUserRole(User $user): ?string
    {
        $permission = $this->users()->wherePivot('user_id', $user->id)->first();
        if ($permission) {
            /** @var \Illuminate\Database\Eloquent\Relations\Pivot $pivot */
            $pivot = $permission->pivot;
            return $pivot->getAttribute('role');
        }
        return null;
    }
}