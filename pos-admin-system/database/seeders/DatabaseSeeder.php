<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tax;
use App\Models\User;
use App\PermissionsEnum;
use App\RolesEnum;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permission = [
            'settings.accounts.create', 'settings.accounts.edit', 'settings.accounts.trash', 'settings.accounts.restore',
            'settings.roles.create', 'settings.roles.edit', 'settings.roles.trash', 'settings.roles.restore',
            'settings.projects.create', 'settings.projects.edit', 'settings.projects.trash', 'settings.projects.restore',
            'settings.projects.taxes.create', 'settings.projects.taxes.edit', 'settings.projects.taxes.trash', 'settings.projects.taxes.restore'
        ];

        $parts = [
            'settings.accounts',
            'settings.roles',
            'settings.projects',
            'settings.projects.taxes',
            'settings.projects.product-attributes',
            'settings.projects.product-categories',
        ];

        foreach ($permission as $perm) {
            Permission::create(['name' => $perm]);
        }

        Role::create([
            'name' => RolesEnum::SUPER_ADMIN,
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => RolesEnum::SUPER_ADMIN,
            'guard_name' => 'api',
        ]);
        $admin = Role::create(['name' => RolesEnum::ADMIN]);

        Role::create(['name' => RolesEnum::CUSTOMER_SERVICE]);
        Role::create(['name' => RolesEnum::PROJECT_MANAGER]);
        Role::create(['name' => RolesEnum::STAFF]);

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@licortech.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password@123'),
        ]);
        $user->assignRole(RolesEnum::SUPER_ADMIN);

        // Demo Project
        $project = Project::create(['name' => 'Demo']);
        $taxes = [
            ['title' => 'VAT10', 'percentage' => 10, 'status' => 1],
            ['title' => 'VAT20', 'percentage' => 20, 'status' => 1]
        ];
        foreach ($taxes as $tax) {
            $project->taxes()->create($tax);
        }

        $project->categories()->create([
            'name' => 'Menu',
            'status' => 1
        ]);
        $attributeSet = $project->productAttributeSets()->create([
            'title' => 'Size',
            'status' => 1
        ]);

        $attributes = [
            ['title' => 'S'], ['title' => 'M'], ['title' => 'L']
        ];
        foreach ($attributes as $attribute) {
            $attributeSet->productAttributes()->create($attribute);
        }
        
    }
}
