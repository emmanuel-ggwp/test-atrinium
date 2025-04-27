<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\RoleAppeal;
use App\Models\User;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\RelatedResponse;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private const RULES_ROLES = [
        'data.attributes.roles' => 'required|array',
        'data.attributes.roles.*' => 'string|exists:roles,name'
    ];

    public function assignRoles(Request $request, User $user)
    {
        $validated = $request->validate(self::RULES_ROLES);

        $roles = $this->validateOnlyValidRoles($validated);

        if ($roles instanceof Error) {
            return $roles;
        }

        $user->assignRole($roles);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //return new RelatedResponse($user, 'roles', $user->roles);
        return response()->json([
            'message' => 'Roles assigned successfully',
            'user' => $user->load('roles')
        ]);
    }

    private function validateOnlyValidRoles(array $data)
    {
        $roles = array_filter($data['data']['attributes']['roles'], function ($role) {
            return $role !== RoleEnum::SUPER_ADMIN->value;
        });

        if (empty($roles)) {
            return Error::fromArray([
                'status' => 400,
                'detail' => 'No valid roles.',
            ]);
        }
        return $roles;
    }
}
