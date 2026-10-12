<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Produksi',
            'Engineering & Desain',
            'Quality Control',
            'Penjualan & Marketing',
            'Purchasing',
            'Logistik & Gudang',
            'Keuangan & Akuntansi',
            'Human Resources & General Affairs',
            'Teknisi & Servis',
            'Manajemen',
        ];

        foreach ($departments as $name) {
            Department::updateOrCreate(['name' => $name]);
        }
    }
}
