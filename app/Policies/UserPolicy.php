<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::VIEW_ANY_USERS->value);
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->can(PermissionEnum::VIEW_USER->value);
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->can(PermissionEnum::UPDATE_USER->value);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can(PermissionEnum::DELETE_USER->value);
    }

}
