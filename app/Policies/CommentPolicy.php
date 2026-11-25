<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Comment;
use App\Models\User;
use App\Models\WorkDay;

class CommentPolicy
{
    /**
     * The employee comments on their own days; a supervisor and an admin on any day.
     */
    public function create(User $user, WorkDay $workDay): bool
    {
        return $workDay->user()->is($user) || $user->hasRole(Role::Supervisor, Role::Admin);
    }

    /**
     * The author edits their own comment; an admin edits any comment.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $comment->author()->is($user) || $user->hasRole(Role::Admin);
    }

    /**
     * The author deletes their own comment; an admin deletes any comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $comment->author()->is($user) || $user->hasRole(Role::Admin);
    }
}
