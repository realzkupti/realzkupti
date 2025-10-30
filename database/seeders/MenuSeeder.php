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
                'has_sticky_note' => true,
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
                'has_sticky_note' => false,
            ],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::create($menuData);

            // Create sub-menus for admin
            if ($menu->key === 'admin') {
                $subMenus = [
                    [
                        'key' => 'admin.users',
                        'label' => 'ผู้ใช้งาน',
                        'icon' => 'users',
                        'route' => 'admin.users',
                        'parent_id' => $menu->id,
                        'sort_order' => 1,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                        'has_sticky_note' => false,
                    ],
                    [
                        'key' => 'admin.departments',
                        'label' => 'แผนก',
                        'icon' => 'briefcase',
                        'route' => 'admin.departments',
                        'parent_id' => $menu->id,
                        'sort_order' => 2,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                        'has_sticky_note' => false,
                    ],
                    [
                        'key' => 'admin.menus',
                        'label' => 'เมนู',
                        'icon' => 'menu',
                        'route' => 'admin.menus',
                        'parent_id' => $menu->id,
                        'sort_order' => 3,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                        'has_sticky_note' => false,
                    ],
                    [
                        'key' => 'admin.permissions',
                        'label' => 'สิทธิ์การใช้งาน',
                        'icon' => 'shield',
                        'route' => 'admin.permissions',
                        'parent_id' => $menu->id,
                        'sort_order' => 4,
                        'department_id' => $systemDept->id,
                        'is_active' => true,
                        'is_system' => true,
                        'has_sticky_note' => false,
                    ],
                ];

                foreach ($subMenus as $subMenu) {
                    Menu::create($subMenu);
                }
            }
        }
    }
}
