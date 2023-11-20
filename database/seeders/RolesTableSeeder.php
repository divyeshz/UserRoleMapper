<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['id' => Str::uuid(),
            'name' => 'Admin',
            'description' => 'Admin Description',
            'is_active' => 1,],
            ['id' => Str::uuid(),
            'name' => 'User',
            'description' => 'User Description',
            'is_active' => 1,],
            ['id' => Str::uuid(),
            'name' => 'Demo',
            'description' => 'Demo Description',
            'is_active' => 1,],
        ]);
    }
}
