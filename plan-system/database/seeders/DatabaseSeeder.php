<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Licortech',
            'email' => 'fx.tiennguyen92@gmail.com',
            'password' => Hash::make('password'),
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
    }
}
