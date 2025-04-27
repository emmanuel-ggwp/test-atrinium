<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleAppealStatusEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\RoleAppeal;
use App\Models\User;
use App\Notifications\RoleAppealResolved;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\RelatedResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Enum;

class RoleAppealController extends Controller
{
    private const RULES_ROLES = [
        'data.attributes.roles' => 'required|array',
        'data.attributes.roles.*' => 'string|exists:roles,name'
    ];

    public function store(Request $request)
    {
        $validated = $request->validate(self::RULES_ROLES);

        $roles = $this->validateOnlyValidRoles($validated);

        if ($roles instanceof Error) {
            return $roles;
        }

        $role_ids = Role::whereIn('name', $roles)->pluck('id')->toArray();

        foreach ($role_ids as $role_id) {
            RoleAppeal::create([
                'user_id' => auth()->id(),
                'role_id' => $role_id,
                'status' => RoleAppealStatusEnum::STATUS_PENDING,
            ]);
        }

        return response()->json([
            'message' => 'Roles appeals created successfully',
        ]);
    }

    public function resolve(Request $request, User $user, RoleAppeal $roleAppeal)
    {
        $validated = $request->validate([
            'data.attributes.status' => [
                'required',
                new Enum(RoleAppealStatusEnum::class)
            ],
        ]);
        

        $newStatus = $validated['data']['attributes']['status'];
        
        $roleAppeal->update([
            'status' => $newStatus,
            //'reviewer_notes' => $validated['data']['attributes']['reviewer_notes'],
            //'resolved_by' => auth()->id(),
            //'resolved_at' => now(),
        ]);

        if($newStatus == RoleAppealStatusEnum::STATUS_ACEPTED->value) {
            $role = $roleAppeal->role; 
            $user = $roleAppeal->user;

            $user->assignRole($role->name);
            $user->notify(new RoleAppealResolved(
                result: $newStatus,
                roles: [$role->name],
                assignedBy: auth()->user() // Or track admin who assigned
            ));

        } else {

        }
        
        return response()->json([
            'message' => 'Role appeal resolved successfully',
        ]);

        //return new RoleAppealResource($appeal);
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