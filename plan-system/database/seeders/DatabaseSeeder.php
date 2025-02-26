<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Project;
use App\Models\User;
use App\RolesEnum;
use App\ScopesEnum;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Super Admin
        $super = User::create([
            'name' => 'Licortech',
            'email' => 'fx.tiennguyen92@gmail.com',
            'password' => Hash::make('password'),
            'scope' => ScopesEnum::SUPER
        ]);
        

        $languages = array(
            ['locale' => 'fr', 'name' => 'Français', 'priority' => 1],
            ['locale' => 'en', 'name' => 'English', 'priority' => 2],
            ['locale' => 'vi', 'name' => 'Tiếng Việt', 'priority' => 3]
        );
        foreach ($languages as $lang) {
            Language::create([
                'locale' => $lang['locale'],
                'name' => $lang['name'],
                'priority' => $lang['priority'],
            ]);
        }

        // Demo
        $project = Project::create([
            'code' => 'demoNailSalon',
            'name' => 'Nail Salon Demo',
            'domain' => 'nail-salon',
            'status' => 1
        ]);
        $director = User::create([
            'name' => 'Director',
            'email' => 'director@demo.com',
            'password' => Hash::make('password'),
            'country_code' => 'FR',
            'phone_number' => '0767310101'
        ]);
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@demo.com',
            'password' => Hash::make('password'),
        ]);
        $staff01 = User::create([
            'name' => 'Staff 01',
            'email' => 'staff01@demo.com',
            'password' => Hash::make('password'),
        ]);
        $staff02 = User::create([
            'name' => 'Staff 02',
            'email' => 'staff02@demo.com',
            'password' => Hash::make('password'),
        ]);

        setPermissionsTeamId($project->id);

        // Super admin
        $super->assignRole(RolesEnum::SUPER_ADMIN);

        // Other roles
        $director->assignRole(RolesEnum::DIRECTOR);
        $manager->assignRole(RolesEnum::MANAGER);
        $staff01->assignRole(RolesEnum::STAFF);
        $staff02->assignRole(RolesEnum::STAFF);

        // Sync accounts with project
        $director->projects()->syncWithoutDetaching($project->id);
        $manager->projects()->syncWithoutDetaching($project->id);
        $staff01->projects()->syncWithoutDetaching($project->id);
        $staff02->projects()->syncWithoutDetaching($project->id);
    }
}
