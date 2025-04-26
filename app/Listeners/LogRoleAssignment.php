<?php

namespace App\Listeners;

use Spatie\Permission\Events\RoleAttached;
use App\Models\User;
use App\Notifications\RoleAssignedNotification;
use Spatie\Permission\Models\Role;

class LogRoleAssignment
{
    public function handle(RoleAttached $event)
    {
        $model = $event->model;
        
        $roleNames = match (true) {
            $event->rolesOrIds instanceof Collection => $event->rolesOrIds->pluck('name')->toArray(),
            is_array($event->rolesOrIds) => $this->convertToRoleNames($event->rolesOrIds),
            $event->rolesOrIds instanceof Role => $this->convertToRoleNames([$event->rolesOrIds]),
            default => throw new \InvalidArgumentException('Invalid rolesOrIds format')
        };

        // Example: Send notification to user
        if ($model instanceof User) {
            
            $model->notify(new RoleAssignedNotification(
                roles: $roleNames,
                assignedBy: auth()->user() // Or track admin who assigned
            ));
        }
    }
    protected function convertToRoleNames(array $roleIds): array
    {
        return \Spatie\Permission\Models\Role::whereIn('id', $roleIds)
            ->pluck('name')
            ->toArray();
    }
}