<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $super_admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super_admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $super_admin->assignRole(RoleEnum::SUPER_ADMIN);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $admin->assignRole(RoleEnum::ADMIN);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $user->assignRole(RoleEnum::USER);
    }
}
