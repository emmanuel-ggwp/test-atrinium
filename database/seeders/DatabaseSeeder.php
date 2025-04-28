<?php

namespace Database\Seeders;

use App\Enums\CompanyStatusEnum;
use App\Enums\DocumentTypeEnum;
use App\Enums\RoleEnum;
use App\Models\ActivityType;
use App\Models\Company;
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

        $companyManager = User::factory()->create([
            'name' => 'Company manager',
            'email' => 'company_manager@example.com',
            'password' => bcrypt('password'),
        ]);

        $companyManager->assignRole(RoleEnum::COMPANY_MANAGER);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleEnum::USER);
        $company = new Company([
            'name' => 'Company 1',
            'email'=> 'Comapny@gmail.com',
            'website' => 'www.company.com',
            'address' => 'Address 1',
            'state' => 'State 1',
            'country' => 'Country 1',
            'document_type' => DocumentTypeEnum::DNI->value,
            'document' => '123456789',
            'status' => CompanyStatusEnum::ACTIVE->value,
        ]);

        $company->owner()->associate($companyManager)->save();

        $activityType1 = ActivityType::create([
            'name' => 'Activity Type 1',
        ]);

        $activityType2 = ActivityType::create([
            'name' => 'Activity Type 2',
        ]);

        $company->activityTypes()->saveMany([$activityType1, $activityType2]);
    }
}
