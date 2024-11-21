<?php

namespace Database\Seeders;

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

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'fx.tiennguyen92@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password@123'),
        ]);

        $user->projects()->create([
            'name' => 'Demo'
        ]);
    }
}
