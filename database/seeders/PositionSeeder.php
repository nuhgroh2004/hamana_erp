<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Produksi' => ['Welder', 'Fabricator', 'Painter', 'Operator CNC', 'Operator Crane', 'Supervisor Produksi', 'Manajer Produksi'],
            'Engineering & Desain' => ['Drafter', 'Engineering Designer'],
            'Quality Control' => ['QC Inspector', 'Staff QA'],
            'Penjualan & Marketing' => ['Sales Executive', 'Staf Penjualan'],
            'Purchasing' => ['Staf Purchasing'],
            'Logistik & Gudang' => ['Staf Gudang', 'Operator Forklift'],
            'Keuangan & Akuntansi' => ['Staf Akuntansi', 'Kasir'],
            'Human Resources & General Affairs' => ['Staf HR & GA', 'Staf HRD'],
            'Teknisi & Servis' => ['Teknisi Servis', 'Mekanik'],
            'Manajemen' => ['Manajer', 'Direktur'],
        ];

        foreach ($positions as $deptName => $names) {
            $department = Department::where('name', $deptName)->first();
            if (!$department) {
                continue;
            }

            foreach ($names as $name) {
                Position::updateOrCreate([
                    'name' => $name,
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
