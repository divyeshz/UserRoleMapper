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
            'code'          => 'lap',
            'name'          => 'Laptop',
            'display_order' => 1,],

            ['id'           => Str::uuid(),
            'code'          => 'cmp',
            'name'          => 'Computer',
            'display_order' => 2,],
        ]);
    }
}
