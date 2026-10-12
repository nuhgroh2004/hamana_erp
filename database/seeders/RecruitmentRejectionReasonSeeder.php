<?php

namespace Database\Seeders;

use App\Modules\Recruitment\Models\RejectionReason;
use Illuminate\Database\Seeder;

class RecruitmentRejectionReasonSeeder extends Seeder
{
    public function run(): void
    {
        $reasons = [
            'Tidak sesuai kualifikasi',
            'Pengalaman kurang',
            'Gagal tes teknis',
            'Gagal interview',
            'Menarik diri sendiri',
            'Lainnya',
        ];

        foreach ($reasons as $name) {
            RejectionReason::updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
