<?php

namespace App\Policies\V1;

use App\Models\Ticket;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::DeleteUser);
    }

    public function replace(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::ReplaceUser);
    }

    public function store(User $user): bool
    {
        return $user->tokenCan(Abilities::CreateUser);
    }

    public function update(User $user, User $model): bool
    {
        return $user->tokenCan(Abilities::UpdateUser);
    }

}
