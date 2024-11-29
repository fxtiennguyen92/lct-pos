<?php

namespace Database\Seeders;

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
            'settings.accounts.create', 'settings.accounts.edit', 'settings.accounts.trash', 'settings.roles.restore',
            'settings.roles.create', 'settings.roles.edit', 'settings.roles.trash', 'settings.roles.restore',
            'settings.projects.create', 'settings.projects.edit', 'settings.projects.trash', 'settings.projects.restore'
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
    }
}
