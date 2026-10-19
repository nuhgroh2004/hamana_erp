<?php

namespace Database\Seeders;

use App\Models\Recruitment\Form;
use Illuminate\Database\Seeder;

class RecruitmentFormDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (Form::withTrashed()->count() > 0) {
            return;
        }

        $lamaran = Form::create([
            'title' => 'Formulir Lamaran Kerja',
            'description' => 'Isi data diri Anda dengan lengkap dan benar.',
            'slug' => Form::makeSlug('Formulir Lamaran Kerja'),
            'is_active' => true,
            'success_msg' => 'Terima kasih, lamaran Anda sudah kami terima.',
            'response_limit' => 0,
            'close_at' => null,
        ]);

        $lamaran->fields()->createMany([
            ['type' => 'text', 'label' => 'Nama Lengkap', 'is_required' => true, 'ord' => 0],
            ['type' => 'date', 'label' => 'Tanggal Lahir', 'is_required' => true, 'ord' => 1],
            ['type' => 'enum', 'label' => 'Posisi yang Dilamar', 'options' => ['Welder 6G', 'Fabricator / Fitter', 'Operator CNC Plasma', 'Painter / Spray', 'Engineer Desain'], 'is_required' => true, 'ord' => 2],
            ['type' => 'radio', 'label' => 'Pendidikan Terakhir', 'options' => ['SMA / SMK', 'D3', 'S1'], 'is_required' => true, 'ord' => 3],
            ['type' => 'check', 'label' => 'Sertifikat yang Dimiliki', 'options' => ['Welder 6G (BNSP)', 'K3 Umum', 'SIO Crane', 'SIO Forklift'], 'is_required' => false, 'ord' => 4],
            ['type' => 'num', 'label' => 'Pengalaman Kerja (tahun)', 'is_required' => false, 'ord' => 5],
            ['type' => 'file', 'label' => 'Unggah CV', 'help' => 'Format PDF, maksimal 5 MB', 'file_types' => ['pdf'], 'max_mb' => 5, 'is_required' => true, 'ord' => 6],
            ['type' => 'file', 'label' => 'Pas Foto', 'help' => 'Format JPG, maksimal 2 MB', 'file_types' => ['jpg'], 'max_mb' => 2, 'is_required' => false, 'ord' => 7],
        ]);

        $f = $lamaran->fields()->get()->keyBy('id');
        $ids = $f->pluck('id');

        $lamaran->responses()->createMany([
            [
                'submitted_at' => now()->subDays(1)->setTime(9, 14),
                'values' => [
                    (string) $ids[0] => 'Rizky Pratama',
                    (string) $ids[1] => '1999-04-12',
                    (string) $ids[2] => 'Welder 6G',
                    (string) $ids[3] => 'SMA / SMK',
                    (string) $ids[4] => ['Welder 6G (BNSP)', 'K3 Umum'],
                    (string) $ids[5] => '5',
                    (string) $ids[6] => 'CV_Rizky.pdf',
                    (string) $ids[7] => 'foto_rizky.jpg',
                ],
            ],
            [
                'submitted_at' => now()->subDays(2)->setTime(15, 40),
                'values' => [
                    (string) $ids[0] => 'Dimas Saputra',
                    (string) $ids[1] => '1997-08-30',
                    (string) $ids[2] => 'Welder 6G',
                    (string) $ids[3] => 'SMA / SMK',
                    (string) $ids[4] => ['Welder 6G (BNSP)'],
                    (string) $ids[5] => '7',
                    (string) $ids[6] => 'CV_Dimas.pdf',
                    (string) $ids[7] => null,
                ],
            ],
            [
                'submitted_at' => now()->subDays(3)->setTime(11, 2),
                'values' => [
                    (string) $ids[0] => 'Nanda Putri',
                    (string) $ids[1] => '1999-01-20',
                    (string) $ids[2] => 'Engineer Desain',
                    (string) $ids[3] => 'S1',
                    (string) $ids[4] => [],
                    (string) $ids[5] => '3',
                    (string) $ids[6] => 'CV_Nanda.pdf',
                    (string) $ids[7] => 'nanda.jpg',
                ],
            ],
        ]);

        $inspeksi = Form::create([
            'title' => 'Laporan Inspeksi Unit Car Carrier',
            'description' => 'Diisi inspektur QC pada setiap tahap produksi.',
            'slug' => Form::makeSlug('Laporan Inspeksi Unit Car Carrier'),
            'is_active' => true,
            'success_msg' => 'Laporan inspeksi tersimpan.',
            'response_limit' => 0,
            'close_at' => null,
        ]);

        $inspeksi->fields()->createMany([
            ['type' => 'text', 'label' => 'Nomor Rangka (VIN)', 'is_required' => true, 'ord' => 0],
            ['type' => 'date', 'label' => 'Tanggal Inspeksi', 'is_required' => true, 'ord' => 1],
            ['type' => 'enum', 'label' => 'Tahap Produksi', 'options' => ['Potong & Bending', 'Pengelasan', 'Perakitan Deck', 'Pengecatan', 'Final Inspection'], 'is_required' => true, 'ord' => 2],
            ['type' => 'radio', 'label' => 'Hasil Inspeksi', 'options' => ['Lulus', 'Lulus Bersyarat', 'Gagal'], 'is_required' => true, 'ord' => 3],
            ['type' => 'long', 'label' => 'Catatan Temuan', 'is_required' => false, 'ord' => 4],
            ['type' => 'file', 'label' => 'Foto / Laporan Temuan', 'help' => 'PDF atau JPG, maksimal 5 MB', 'file_types' => ['pdf', 'jpg'], 'max_mb' => 5, 'is_required' => false, 'ord' => 5],
        ]);

        $fi = $inspeksi->fields()->get()->keyBy('id');
        $ii = $fi->pluck('id');

        $inspeksi->responses()->createMany([
            [
                'submitted_at' => now()->subDay()->setTime(8, 20),
                'values' => [
                    (string) $ii[0] => 'MHKF1234AB567890',
                    (string) $ii[1] => now()->subDay()->format('Y-m-d'),
                    (string) $ii[2] => 'Pengelasan',
                    (string) $ii[3] => 'Lulus Bersyarat',
                    (string) $ii[4] => 'Las sambungan ramp perlu diulang.',
                    (string) $ii[5] => 'temuan_las.jpg',
                ],
            ],
            [
                'submitted_at' => now()->subDays(2)->setTime(16, 5),
                'values' => [
                    (string) $ii[0] => 'MHKF1234AB567891',
                    (string) $ii[1] => now()->subDays(2)->format('Y-m-d'),
                    (string) $ii[2] => 'Final Inspection',
                    (string) $ii[3] => 'Lulus',
                    (string) $ii[4] => null,
                    (string) $ii[5] => null,
                ],
            ],
        ]);

        $cuti = Form::create([
            'title' => 'Permintaan Cuti Karyawan',
            'description' => 'Ajukan cuti minimal 3 hari sebelumnya.',
            'slug' => Form::makeSlug('Permintaan Cuti Karyawan'),
            'is_active' => false,
            'success_msg' => 'Pengajuan cuti terkirim.',
            'response_limit' => 0,
            'close_at' => null,
        ]);

        $cuti->fields()->createMany([
            ['type' => 'text', 'label' => 'Nama Karyawan', 'is_required' => true, 'ord' => 0],
            ['type' => 'date', 'label' => 'Tanggal Mulai', 'is_required' => true, 'ord' => 1],
            ['type' => 'date', 'label' => 'Tanggal Selesai', 'is_required' => true, 'ord' => 2],
            ['type' => 'enum', 'label' => 'Jenis Cuti', 'options' => ['Tahunan', 'Sakit', 'Melahirkan', 'Khusus'], 'is_required' => true, 'ord' => 3],
            ['type' => 'file', 'label' => 'Surat Dokter', 'file_types' => ['pdf', 'jpg'], 'max_mb' => 3, 'is_required' => false, 'ord' => 4],
        ]);
    }
}
