<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()->count(10)->create();
        User::create([
            'username' => 'Light1',
            'role_id' => 1,
            'name' => 'Rama',
            'email' => 'rama@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'username' => 'Yodeler',
            'role_id' => 1,
            'name' => 'Rama',
            'email' => 'rama1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'username' => 'LightY',
            'role_id' => 1,
            'name' => 'Rama',
            'email' => 'rama2@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
