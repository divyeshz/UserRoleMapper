<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['id'           => Str::uuid(),
            'name'          => 'Admin',
            'description'   => 'Admin description',],

            ['id'           => Str::uuid(),
            'name'          => 'User',
            'description'   => 'User description',],
        ]);
    }
}
