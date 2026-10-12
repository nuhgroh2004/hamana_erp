<?php

namespace Database\Seeders;

use App\Modules\Recruitment\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class RecruitmentEmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'application_received',
                'subject' => 'Kami telah menerima lamaran Anda',
                'body' => "Halo {kandidat},\n\nTerima kasih telah melamar posisi {lowongan} di Hamana Worksindo. Lamaran Anda sudah kami terima dan akan kami proses.\n\nHormat kami,\nTim HRD",
            ],
            [
                'key' => 'stage_changed',
                'subject' => 'Update tahap seleksi rekrutmen',
                'body' => "Halo {kandidat},\n\nLamaran Anda untuk posisi {lowongan} saat ini berada di tahap {tahap}.\n\nHormat kami,\nTim HRD",
            ],
            [
                'key' => 'application_rejected',
                'subject' => 'Hasil lamaran Anda di Hamana Worksindo',
                'body' => "Halo {kandidat},\n\nMohon maaf, lamaran Anda untuk posisi {lowongan} belum dapat kami lanjutkan. Terima kasih atas minat Anda terhadap Hamana Worksindo.\n\nHormat kami,\nTim HRD",
            ],
            [
                'key' => 'offer_sent',
                'subject' => 'Penawaran kerja dari Hamana Worksindo',
                'body' => "Halo {kandidat},\n\nKami dengan senang hati menawarkan posisi {lowongan} kepada Anda. Detail penawaran terlampir. Mohon balas sebelum tanggal berlaku berakhir.\n\nHormat kami,\nTim HRD",
            ],
        ];

        foreach ($templates as $t) {
            EmailTemplate::updateOrCreate(['key' => $t['key']], $t + ['is_active' => true]);
        }
    }
}
