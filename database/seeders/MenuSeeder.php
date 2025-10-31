<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemDept = Department::where('key', 'system')->first();

        $menus = [
            // Dashboard
            [
                'key' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'home',
                'route' => 'dashboard',
                'parent_id' => null,
                'sort_order' => 1,
                'department_id' => $systemDept->id,
                'is_active' => true,
                'is_system' => true,
            ],

            // Admin Menu (Parent)
            [
                'key' => 'admin',
                'label' => 'จัดการระบบ',
                'icon' => 'settings',
                'route' => null,
                'parent_id' => null,
                'sort_order' => 2,
                'department_id' => $systemDept->id,
                'is_active' => true,
                'is_system' => true,
            ],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::create($menuData);

            // Create sub-menus for admin
            if ($menu->key === 'admin') {
                $subMenus = [
                    [
                        'key' => 'admin.users',
                        'label' => 'จัดการผู้ใช้งาน',
                        'icon' => 'users',
                        'route' => 'admin.users',
                        'parent_id' => $menu->id,
                        'sort_order' => 1,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                    ],
                    [
                        'key' => 'admin.departments',
                        'label' => 'จัดการแผนก',
                        'icon' => 'briefcase',
                        'route' => 'admin.departments',
                        'parent_id' => $menu->id,
                        'sort_order' => 2,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                    ],
                    [
                        'key' => 'admin.menus',
                        'label' => 'จัดการเมนู',
                        'icon' => 'menu',
                        'route' => 'admin.menus',
                        'parent_id' => $menu->id,
                        'sort_order' => 3,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                    ],
                    [
                        'key' => 'admin.permissions.departments',
                        'label' => 'สิทธิ์ตามแผนก',
                        'icon' => 'shield',
                        'route' => 'admin.permissions.departments',
                        'parent_id' => $menu->id,
                        'sort_order' => 4,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                    ],
                    [
                        'key' => 'admin.permissions.users',
                        'label' => 'สิทธิ์ตามผู้ใช้',
                        'icon' => 'user-check',
                        'route' => 'admin.permissions.users',
                        'parent_id' => $menu->id,
                        'sort_order' => 5,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                    ],
                ];

                foreach ($subMenus as $subMenu) {
                    Menu::create($subMenu);
                }
            }
        }
    }
}
