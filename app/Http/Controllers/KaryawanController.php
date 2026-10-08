<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    private const VALUE_FIELDS = ['nama', 'ktp', 'tmpLahir', 'tglLahir', 'jk', 'kawin', 'hp', 'email', 'alamat', 'divisi', 'jabatan', 'statusKerja'];

    public function show(string $nik): JsonResponse
    {
        $k = Karyawan::find($nik);

        if (!$k) {
            return response()->json([
                'values' => [],
                'extra' => [],
                'karier' => [],
                'pendidikan' => [],
                'dokumen' => [],
            ]);
        }

        $values = [];
        foreach (self::VALUE_FIELDS as $field) {
            $values[$field] = $k->{$field};
        }

        return response()->json([
            'values' => $values,
            'extra' => $k->extra ?: [],
            'karier' => $k->karier ?: [],
            'pendidikan' => $k->pendidikan ?: [],
            'dokumen' => $k->dokumen ?: [],
        ]);
    }

    public function save(Request $request, string $nik): JsonResponse
    {
        $data = $request->validate([
            'values' => ['required', 'array'],
            'values.nama' => ['required', 'string', 'max:255'],
            'values.divisi' => ['required', 'string', 'max:255'],
            'values.jabatan' => ['required', 'string', 'max:255'],
            'values.ktp' => ['nullable', 'string', 'max:255'],
            'values.tmpLahir' => ['nullable', 'string', 'max:255'],
            'values.tglLahir' => ['nullable', 'string', 'max:255'],
            'values.jk' => ['nullable', 'string', 'max:255'],
            'values.kawin' => ['nullable', 'string', 'max:255'],
            'values.hp' => ['nullable', 'string', 'max:255'],
            'values.email' => ['nullable', 'string', 'max:255'],
            'values.alamat' => ['nullable', 'string', 'max:255'],
            'values.statusKerja' => ['nullable', 'string', 'max:255'],
            'extra' => ['nullable', 'array'],
            'karier' => ['nullable', 'array'],
            'pendidikan' => ['nullable', 'array'],
            'dokumen' => ['nullable', 'array'],
        ], [
            'values.nama' => __('Nama, divisi, dan jabatan wajib diisi.'),
            'values.divisi' => __('Nama, divisi, dan jabatan wajib diisi.'),
            'values.jabatan' => __('Nama, divisi, dan jabatan wajib diisi.'),
        ]);

        $values = $data['values'];

        Karyawan::updateOrCreate(['nik' => $nik], [
            'nama' => $values['nama'],
            'ktp' => $values['ktp'] ?? null,
            'tmpLahir' => $values['tmpLahir'] ?? null,
            'tglLahir' => $values['tglLahir'] ?? null,
            'jk' => $values['jk'] ?? null,
            'kawin' => $values['kawin'] ?? null,
            'hp' => $values['hp'] ?? null,
            'email' => $values['email'] ?? null,
            'alamat' => $values['alamat'] ?? null,
            'divisi' => $values['divisi'],
            'jabatan' => $values['jabatan'],
            'statusKerja' => $values['statusKerja'] ?? null,
            'extra' => $data['extra'] ?? [],
            'karier' => $data['karier'] ?? [],
            'pendidikan' => $data['pendidikan'] ?? [],
            'dokumen' => $data['dokumen'] ?? [],
        ]);

        return response()->json(['ok' => true]);
    }
}
