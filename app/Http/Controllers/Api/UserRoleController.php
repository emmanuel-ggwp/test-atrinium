<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Document\Error;

class UserRoleController extends Controller
{
    public function assignRoles(Request $request, User $user)
    {
        $validated = $request->validate([
            'data.attributes.roles' => 'required|array',
            'data.attributes.roles.*' => 'string|exists:roles,name'
        ]);
    
        $roles = array_filter($validated['data']['attributes']['roles'], function ($role) {
            return $role !== RoleEnum::SUPER_ADMIN->value;
        });
        
        if (empty($roles)) {
            return Error::fromArray([
                'status' => 400,
                'detail' => 'No valid roles.',
            ]);
        }

        $user->assignRole($roles);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return response()->json([
            'message' => 'Roles assigned successfully',
            'user' => $user->load('roles')
        ]);
    }
}
