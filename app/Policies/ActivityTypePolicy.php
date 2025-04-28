<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActivityTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::VIEW_ANY_ACTIVITY_TYPE_POLICY->value);
    }

    public function view(User $user, ActivityType $activityType): bool
    {
        return $user->can(PermissionEnum::VIEW_ACTIVITY_TYPE_POLICY->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionEnum::CREATE_ACTIVITY_TYPE_POLICY->value);
    }
}
