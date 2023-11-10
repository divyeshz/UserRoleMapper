<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new user with admin type
        User::create([
            'id' => '10c197af-5842-425f-aa80-334aa77afacf',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'is_active' => 1,
            'is_first_login' => 0,
            'code' => null,
            'type' => 'admin',
        ]);
    }
}
