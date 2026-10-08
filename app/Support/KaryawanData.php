<?php

namespace App\Support;

class KaryawanData
{
    public static function all(): array
    {
        return [
            [
                'nik' => 'HW-24001',
                'nama' => 'Ahmad Fauzi',
                'ktp' => '3274011505880003',
                'tmpLahir' => 'Cikarang',
                'tglLahir' => '12 Mei 1990',
                'jk' => 'Laki-laki',
                'kawin' => 'Kawin',
                'alamat' => 'Kp. Cabangbungin No. 12, Tambun Selatan, Kab. Bekasi',
                'hp' => '0812-8877-4521',
                'email' => 'ahmad.fauzi@hamana.co.id',
                'tglMasuk' => '03 Februari 2019',
                'statusKerja' => 'Tetap',
                'divisi' => 'Produksi',
                'jabatan' => 'Welder Senior',
                'atasan' => 'Kepala Divisi Produksi',
                'lokasi' => 'Plant Cikarang',
                'jenjang' => 'SMA / SMK',
                'institusi' => 'SMK Negeri 1 Cikarang',
                'jurusan' => 'Teknik Pengelasan',
                'lulus' => '2012',
                'karier' => [
                    ['tglMasuk' => '10 Januari 2015', 'statusKerja' => 'Kontrak', 'divisi' => 'Produksi', 'jabatan' => 'Welder', 'atasan' => 'Kepala Divisi Produksi', 'lokasi' => 'Plant Cikarang'],
                    ['tglMasuk' => '03 Februari 2019', 'statusKerja' => 'Tetap', 'divisi' => 'Produksi', 'jabatan' => 'Welder Senior', 'atasan' => 'Kepala Divisi Produksi', 'lokasi' => 'Plant Cikarang'],
                ],
                'pendidikan' => [
                    ['jenjang' => 'SMP', 'institusi' => 'SMP Negeri 5 Cikarang', 'jurusan' => 'Umum', 'lulus' => '2009'],
                    ['jenjang' => 'SMA / SMK', 'institusi' => 'SMK Negeri 1 Cikarang', 'jurusan' => 'Teknik Pengelasan', 'lulus' => '2012'],
                ],
                'dokumen' => [
                    ['nama' => 'KTP', 'nomor' => '3274011505880003', 'berlaku' => 'Seumur hidup', 'status' => 'Aktif'],
                    ['nama' => 'Kartu Keluarga', 'nomor' => '3274051008120004', 'berlaku' => 'Seumur hidup', 'status' => 'Aktif'],
                    ['nama' => 'Ijazah SMK', 'nomor' => 'IJ-SMK1CKR-2012-0912', 'berlaku' => 'Seumur hidup', 'status' => 'Aktif'],
                    ['nama' => 'Sertifikat Welder AWS', 'nomor' => 'AWS-SC-2024-1187', 'berlaku' => '31 Des 2026', 'status' => 'Akan Habis'],
                ],
            ],
            [
                'nik' => 'HW-24002',
                'nama' => 'Siti Rahayu',
                'ktp' => '3273024802950001',
                'tmpLahir' => 'Bekasi',
                'tglLahir' => '04 Februari 1995',
                'jk' => 'Perempuan',
                'kawin' => 'Belum Kawin',
                'alamat' => 'Jl. Ahmad Yani No. 88, Bekasi Selatan, Kota Bekasi',
                'hp' => '0857-2211-9043',
                'email' => 'siti.rahayu@hamana.co.id',
                'tglMasuk' => '15 Agustus 2021',
                'statusKerja' => 'Kontrak',
                'divisi' => 'Administrasi',
                'jabatan' => 'Staf HR & GA',
                'atasan' => 'Manajer SDM',
                'lokasi' => 'Kantor Pusat',
                'jenjang' => 'D3',
                'institusi' => 'Politeknik Negeri Bekasi',
                'jurusan' => 'Administrasi Bisnis',
                'lulus' => '2017',
                'karier' => [
                    ['tglMasuk' => '15 Agustus 2021', 'statusKerja' => 'Kontrak', 'divisi' => 'Administrasi', 'jabatan' => 'Staf HR & GA', 'atasan' => 'Manajer SDM', 'lokasi' => 'Kantor Pusat'],
                ],
                'pendidikan' => [
                    ['jenjang' => 'SMA / SMK', 'institusi' => 'SMA Negeri 3 Bekasi', 'jurusan' => 'IPA', 'lulus' => '2013'],
                    ['jenjang' => 'D3', 'institusi' => 'Politeknik Negeri Bekasi', 'jurusan' => 'Administrasi Bisnis', 'lulus' => '2017'],
                ],
                'dokumen' => [
                    ['nama' => 'KTP', 'nomor' => '3273024802950001', 'berlaku' => 'Seumur hidup', 'status' => 'Aktif'],
                    ['nama' => 'Kartu Keluarga', 'nomor' => '3273050501170002', 'berlaku' => 'Seumur hidup', 'status' => 'Aktif'],
                    ['nama' => 'Ijazah D3', 'nomor' => 'IJ-D3PNB-2017-0441', 'berlaku' => 'Seumur hidup', 'status' => 'Aktif'],
                    ['nama' => 'NPWP', 'nomor' => '18.234.567.8-423.000', 'berlaku' => 'Seumur hidup', 'status' => 'Menunggu'],
                ],
            ],
        ];
    }

    public static function find(?string $nik): ?array
    {
        foreach (self::all() as $k) {
            if ($k['nik'] === $nik) {
                return $k;
            }
        }

        return null;
    }
}
