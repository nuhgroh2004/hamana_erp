<?php

namespace Database\Seeders;

use App\Modules\Recruitment\Models\Source;
use Illuminate\Database\Seeder;

class RecruitmentSourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            'Referensi Karyawan',
            'Walk-in',
            'Website Perusahaan',
            'Instagram / Media Sosial',
            'Job Board',
            'Lainnya',
        ];

        foreach ($sources as $name) {
            Source::updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
