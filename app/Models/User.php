<?php

namespace App\Models;

use App\Enums\Role;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Default values, mirroring the column defaults in the migration.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => 'employee',
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
            'role' => Role::class,
        ];
    }

    /**
     * Check whether the user has any of the given roles.
     */
    public function hasRole(Role ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    /**
     * Work days recorded for this user.
     *
     * @return HasMany<WorkDay, $this>
     */
    public function workDays(): HasMany
    {
        return $this->hasMany(WorkDay::class);
    }

    /**
     * Work days of the given month, oldest first, with the data the day list shows.
     *
     * @return Collection<int, WorkDay>
     */
    public function workDaysInMonth(CarbonInterface $month): Collection
    {
        return $this->workDays()
            ->inMonth($month)
            ->with('updatedBy')
            ->withCount('comments')
            ->orderBy('date')
            ->get();
    }
}
