<?php

namespace Database\Seeders;
use App\Services\PermissionRoleService;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        PermissionRoleService::setup();
    }
}
