<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountModuleId = Str::uuid(); // Generate UUID for Account module
        Module::insert([
            [
                'id' => $accountModuleId,
                'code' => 'acc',
                'name' => 'Account',
                'display_order' => 1,
                'parent_id' => null,
            ],
        ]);

        $accountModule = Module::find($accountModuleId); // Retrieve the Account module

        if ($accountModule) {
            Module::insert([
                [
                    'id' => Str::uuid(),
                    'code' => 'role',
                    'name' => 'Role',
                    'display_order' => 2,
                    'parent_id' => $accountModuleId, // Assign Account module's ID as parent_id
                ],
                [
                    'id' => Str::uuid(),
                    'code' => 'perm',
                    'name' => 'Permission',
                    'display_order' => 3,
                    'parent_id' => $accountModuleId, // Assign Account module's ID as parent_id
                ],
                [
                    'id' => Str::uuid(),
                    'code' => 'user',
                    'name' => 'User',
                    'display_order' => 4,
                    'parent_id' => $accountModuleId, // Assign Account module's ID as parent_id
                ],
                [
                    'id' => Str::uuid(),
                    'code' => 'module',
                    'name' => 'Module',
                    'display_order' => 5,
                    'parent_id' => $accountModuleId, // Assign Account module's ID as parent_id
                ],
            ]);
        }
    }

}
