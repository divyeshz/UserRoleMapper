<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::insert([
            ['id'           =>  Str::uuid(),
            'code'          => 'acc',
            'name'          => 'Account',
            'display_order' => 1,],

            ['id'           =>  Str::uuid(),
            'code'          => 'role',
            'name'          => 'Role',
            'display_order' => 2,],

            ['id'           =>  Str::uuid(),
            'code'          => 'perm',
            'name'          => 'Permission',
            'display_order' => 3,],

            ['id'           => Str::uuid(),
            'code'          => 'user',
            'name'          => 'User',
            'display_order' => 4,],
        ]);
    }
}
