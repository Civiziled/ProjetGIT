<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
     use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
public function view(User $authUser, User $user)
{
    return $authUser->role === 'admin' || $authUser->id === $user->id;
}

public function viewAny(User $authUser)
{
    return $authUser->role === 'admin';
}

public function create(User $authUser)
{
     return $authUser->role === 'admin';
}

public function update(User $authUser, User $user)
{
    return $authUser->role === 'admin';
}

public function delete(User $authUser, User $user)
{
    return $authUser->role === 'admin';
}

    }
