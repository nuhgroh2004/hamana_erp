<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $primaryKey = 'nik';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'nama',
        'ktp',
        'tmpLahir',
        'tglLahir',
        'jk',
        'kawin',
        'hp',
        'email',
        'alamat',
        'divisi',
        'jabatan',
        'statusKerja',
        'extra',
        'karier',
        'pendidikan',
        'dokumen',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'karier' => 'array',
            'pendidikan' => 'array',
            'dokumen' => 'array',
        ];
    }
}
