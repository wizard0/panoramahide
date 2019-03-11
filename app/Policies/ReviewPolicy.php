<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function browse(User $user)
    {
        return $user->isAdmin();
    }

    public function edit(User $user)
    {
        return $user->isAdmin();
    }

    public function add(User $user)
    {
        return $user->isAdmin();
    }

    public function delete(User $user)
    {
        return $user->isAdmin();
    }

    public function read(User $user)
    {
        return $user->isAdmin();
    }
}
