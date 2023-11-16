<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['id'           => 'd1f188eb-a44b-4471-8eea-90f1fd4bc81e',
            'name'          => 'Admin',
            'description'   => 'Admin description',],

            ['id'           => '2687aa9a-a046-4225-9a4c-1c442edbbcd6',
            'name'          => 'User',
            'description'   => 'User description',],
        ]);
    }
}
