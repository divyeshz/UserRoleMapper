<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['id' => '7c8e0cbb-ccd3-462b-ba60-151eda62ecb9',
            'name' => 'Admin',
            'description' => 'Admin Description',
            'is_active' => 1,],
            ['id' => '7a6c29eb-efb7-4dcc-99cd-f4c67acb58be',
            'name' => 'User',
            'description' => 'User Description',
            'is_active' => 1,],
            ['id' => 'f152b541-25b5-46db-9bd6-1f823b6c7266',
            'name' => 'Demo',
            'description' => 'Demo Description',
            'is_active' => 1,],
        ]);
    }
}
