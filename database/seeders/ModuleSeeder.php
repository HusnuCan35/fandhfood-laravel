<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            ['module_name' => 'cards', 'module_status' => true],
            ['module_name' => 'why_us', 'module_status' => true],
            ['module_name' => 'products', 'module_status' => true],
            ['module_name' => 'comments', 'module_status' => true],
            ['module_name' => 'our_branches', 'module_status' => true],
            ['module_name' => 'who_are_we', 'module_status' => true],
        ];

        foreach ($modules as $module) {
            Module::create($module);
        }
    }
}
