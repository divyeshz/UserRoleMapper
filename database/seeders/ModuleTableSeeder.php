<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::insert([
            ['id'           => '42f5a14f-477b-4f49-8f37-eb0728086a16',
            'code'          => 'lap',
            'name'          => 'Laptop',
            'display_order' => 1,],

            ['id'           => '8ab5111f-afb9-4181-8272-e6e937036838',
            'code'          => 'cmp',
            'name'          => 'Computer',
            'display_order' => 2,],
        ]);
    }
}
