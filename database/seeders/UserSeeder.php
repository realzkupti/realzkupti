<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemDept = Department::where('key', 'system')->first();

        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@local',
            'password' => Hash::make('password'),
            'is_active' => true,
            'department_id' => $systemDept->id,
            'email_verified_at' => now(),
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'department_id' => $systemDept->id,
            'email_verified_at' => now(),
        ]);
    }
}
