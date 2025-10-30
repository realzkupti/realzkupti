<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Menu;
use App\Models\DepartmentMenuPermission;
use Illuminate\Database\Seeder;

class DepartmentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemDept = Department::where('key', 'system')->first();

        if (!$systemDept) {
            $this->command->error('System department not found!');
            return;
        }

        // Get all menus
        $menus = Menu::all();

        $this->command->info("Creating permissions for System department...");

        foreach ($menus as $menu) {
            // System department gets full access to all menus
            DepartmentMenuPermission::create([
                'department_id' => $systemDept->id,
                'menu_id' => $menu->id,
                'can_view' => true,
                'can_create' => true,
                'can_update' => true,
                'can_delete' => true,
                'can_export' => true,
                'can_approve' => true,
            ]);

            $this->command->info("  ✓ {$menu->label} - Full access granted");
        }

        // Other departments: Basic permissions for dashboard only
        $otherDepartments = Department::where('key', '!=', 'system')->get();
        $dashboardMenu = Menu::where('key', 'dashboard')->first();

        if ($dashboardMenu) {
            foreach ($otherDepartments as $dept) {
                DepartmentMenuPermission::create([
                    'department_id' => $dept->id,
                    'menu_id' => $dashboardMenu->id,
                    'can_view' => true,
                    'can_create' => false,
                    'can_update' => false,
                    'can_delete' => false,
                    'can_export' => false,
                    'can_approve' => false,
                ]);

                $this->command->info("✓ {$dept->label} department - Dashboard view access granted");
            }
        }

        $this->command->info("Department permissions seeded successfully!");
    }
}
