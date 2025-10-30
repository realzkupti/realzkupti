<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'key' => 'system',
                'label' => 'ระบบจัดการ',
                'sort_order' => 1,
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'key' => 'finance',
                'label' => 'การเงิน',
                'sort_order' => 2,
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'key' => 'hr',
                'label' => 'ทรัพยากรบุคคล',
                'sort_order' => 3,
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'key' => 'sales',
                'label' => 'ขายและการตลาด',
                'sort_order' => 4,
                'is_active' => true,
                'is_default' => false,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
