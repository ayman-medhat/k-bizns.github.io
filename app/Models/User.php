<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use BelongsToTenant, HasFactory, HasRoles, Notifiable;

    public function company_id(): string
    {
        return 'company_id';
    } // Helper if needed

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'manager_id', // Adding manager_id for hierarchy as well
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_root' => 'boolean',
        ];
    }

    public function isRoot(): bool
    {
        return (bool) $this->is_root;
    }

    protected static function booted()
    {
        static::updating(function ($user) {
            if ($user->getOriginal('is_root')) {
                // Prevent email change
                if ($user->isDirty('email')) {
                    $user->email = $user->getOriginal('email');
                }

                // Prevent is_root change
                if ($user->isDirty('is_root')) {
                    $user->is_root = $user->getOriginal('is_root');
                }

                // Only allow password change if the authenticated user is the root user themselves
                // Actually, the requirement says "The root user can change his own password only."
                // "This user cannot be edited by any other user, including other admins."

                $authUser = auth()->user();

                if (!$authUser || $authUser->id !== $user->id) {
                    // Block unauthorized updates (e.g. by other admins)
                    return false;
                }

                // If it IS the root user, they can only change password
                // We check if anything other than password or hidden fields are changed
                $dirty = $user->getDirty();
                unset($dirty['password']);
                unset($dirty['updated_at']);

                if (!empty($dirty)) {
                    // Revert all other changes
                    foreach ($dirty as $key => $value) {
                        $user->$key = $user->getOriginal($key);
                    }
                }
            }
        });

        static::deleting(function ($user) {
            if ($user->is_root) {
                return false;
            }
        });
    }

    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function subordinates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    /**
     * Get IDs of all subordinates (direct and indirect)
     */
    public function getAllSubordinateIds(array &$visited = []): array
    {
        if (in_array($this->id, $visited)) {
            return [];
        }

        $visited[] = $this->id;

        $ids = $this->subordinates()->pluck('id')->toArray();

        foreach ($this->subordinates as $subordinate) {
            $ids = array_merge($ids, $subordinate->getAllSubordinateIds($visited));
        }

        return array_unique($ids);
    }
}
