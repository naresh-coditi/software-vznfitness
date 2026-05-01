<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => User::Admin
        ]);

        UserProfile::create([
            'first_name' => 'admin',
            'user_id' => $user->id,
            'gender' => 'male',
        ]);
    }
}
