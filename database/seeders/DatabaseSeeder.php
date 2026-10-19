<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\User;
use App\Support\KaryawanData;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@local.com'], [
            'name' => 'Super Admin',
            'password' => '123',
            'role' => 'superadmin',
            'locale' => 'id',
        ]);

        User::updateOrCreate(['email' => 'user@hamana.local'], [
            'name' => 'User Biasa',
            'password' => 'user123',
            'role' => 'user',
            'locale' => 'id',
        ]);

        foreach (KaryawanData::all() as $k) {
            Karyawan::updateOrCreate(['nik' => $k['nik']], [
                'nama' => $k['nama'],
                'ktp' => $k['ktp'],
                'tmpLahir' => $k['tmpLahir'],
                'tglLahir' => $k['tglLahir'],
                'jk' => $k['jk'],
                'kawin' => $k['kawin'],
                'alamat' => $k['alamat'],
                'hp' => $k['hp'],
                'email' => $k['email'],
                'divisi' => $k['divisi'],
                'jabatan' => $k['jabatan'],
                'statusKerja' => $k['statusKerja'],
                'extra' => [],
                'karier' => $k['karier'] ?? [],
                'pendidikan' => $k['pendidikan'] ?? [],
                'dokumen' => $k['dokumen'] ?? [],
            ]);
        }

        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
        ]);
    }
}
