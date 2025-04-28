<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::VIEW_ANY_COMPANIES->value);
    }

    public function view(User $user, Company $company): bool
    {
        return $user->id === $company->owner->id || $user->can(PermissionEnum::VIEW_COMPANY->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionEnum::CREATE_COMPANY->value);
    }

    public function update(User $user, Company $company): bool
    {
        return $user->id === $company->owner()->id || $user->can(PermissionEnum::UPDATE_COMPANY->value);
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->id === $company->owner()->id || $user->can(PermissionEnum::DELETE_COMPANY->value);
    }

    public function viewOwner(User $user, Company $company): bool
    {
        return $this->view($user, $company);
    }

    public function viewActivityTypes(User $user, Company $company): bool
    {
        return $this->view($user, $company);
    }
}
