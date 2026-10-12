<?php

namespace Database\Seeders;

use App\Modules\Recruitment\Models\OnboardingTemplate;
use Illuminate\Database\Seeder;

class RecruitmentOnboardingTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Kontrak kerja ditandatangani',
            'Unggah dokumen lengkap (KTP, Ijazah, NPWP)',
            'Medical check-up',
            'Pendaftaran BPJS Kesehatan & Ketenagakerjaan',
            'Penyerahan APD',
            'Induksi K3',
            'Pembuatan akun & akses sistem',
            'Penetapan mentor',
        ];

        foreach ($titles as $i => $title) {
            OnboardingTemplate::updateOrCreate(['title' => $title], [
                'order' => $i + 1,
                'is_active' => true,
            ]);
        }
    }
}
