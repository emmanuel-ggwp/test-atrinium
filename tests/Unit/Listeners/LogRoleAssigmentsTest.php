<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\User;
use App\Notifications\RoleAssigned;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Events\RoleAttached;
use Spatie\Permission\Models\Role;

class LogRoleAssigmentsTest extends TestCase
{
    use RefreshDatabase;
    public function test_notification_sent_on_role_assignment()
    {
        Notification::fake();

        $user = User::factory()->create();
        $role = Role::create(['name' => 'editor']);

        event(new RoleAttached($user, $role));

        Notification::assertSentTo(
            $user,
            RoleAssigned::class
        );
    }
}
