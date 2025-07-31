<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->tokenCan('users:viewAny')) {
            return true;
        } else {
            return false;
        }
    }

    public function view(User $user): bool
    {
        if ($user->tokenCan('users:view')) {
            return true;
        } else {
            return false;
        }
    }

    public function create(User $user): bool
    {
        if ($user->tokenCan('users:create')) {
            return true;
        } else {
            return false;
        }
    }

    public function update(User $user): bool
    {
        if ($user->tokenCan('users:update')) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user): bool
    {
        if ($user->tokenCan('users:delete')) {
            return true;
        } else {
            return false;
        }
    }
}
