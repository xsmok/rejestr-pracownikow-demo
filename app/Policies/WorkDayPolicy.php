<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\WorkDay;

class WorkDayPolicy
{
    /**
     * The employee sees their own days; a supervisor and an admin see every day.
     */
    public function view(User $user, WorkDay $workDay): bool
    {
        return $workDay->user()->is($user) || $user->hasRole(Role::Supervisor, Role::Admin);
    }

    /**
     * Only a supervisor or an admin records hours.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Supervisor, Role::Admin);
    }

    /**
     * Only a supervisor or an admin changes recorded hours.
     */
    public function update(User $user, WorkDay $workDay): bool
    {
        return $user->hasRole(Role::Supervisor, Role::Admin);
    }

    /**
     * Only a supervisor or an admin deletes a day.
     */
    public function delete(User $user, WorkDay $workDay): bool
    {
        return $user->hasRole(Role::Supervisor, Role::Admin);
    }
}
