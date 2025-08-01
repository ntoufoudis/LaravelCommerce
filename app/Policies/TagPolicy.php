<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->can('tags:viewAny')) {
            return true;
        } else {
            return false;
        }
    }

    public function view(User $user): bool
    {
        if ($user->can('tags:view')) {
            return true;
        } else {
            return false;
        }
    }

    public function create(User $user): bool
    {
        if ($user->can('tags:create')) {
            return true;
        } else {
            return false;
        }
    }

    public function update(User $user): bool
    {
        if ($user->can('tags:update')) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user): bool
    {
        if ($user->can('tags:delete')) {
            return true;
        } else {
            return false;
        }
    }
}
