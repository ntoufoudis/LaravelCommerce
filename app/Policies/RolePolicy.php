<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->can('roles:viewAny')) {
            return true;
        } else {
            return false;
        }
    }

    public function view(User $user): bool
    {
        if ($user->can('roles:view')) {
            return true;
        } else {
            return false;
        }
    }

    public function create(User $user): bool
    {
        if ($user->can('roles:create')) {
            return true;
        } else {
            return false;
        }
    }

    public function update(User $user): bool
    {
        if ($user->can('roles:update')) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user): bool
    {
        if ($user->can('roles:delete')) {
            return true;
        } else {
            return false;
        }
    }
}
