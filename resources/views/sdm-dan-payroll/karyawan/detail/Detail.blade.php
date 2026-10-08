@php
    $nikParam = request('nik');
    $k = null;
    if (request('new')) {
        $max = \App\Models\Karyawan::pluck('nik')->map(fn ($n) => (int) preg_replace('/\D+/', '', $n))->max() ?? 0;
        $nikParam = 'HW-' . str_pad((string) ($max + 1), 5, '0', STR_PAD_LEFT);
    } elseif ($nikParam) {
        $k = \App\Models\Karyawan::find($nikParam);
    } else {
        $k = \App\Models\Karyawan::orderBy('nik')->first();
    }
    if (!$k) {
        if (!$nikParam) {
            $max = \App\Models\Karyawan::pluck('nik')->map(fn ($n) => (int) preg_replace('/\D+/', '', $n))->max() ?? 0;
            $nikParam = 'HW-' . str_pad((string) ($max + 1), 5, '0', STR_PAD_LEFT);
        }
        $k = new \App\Models\Karyawan(['nik' => $nikParam]);
    }
    $emp = array_merge([
        'nik' => '', 'nama' => '', 'ktp' => '', 'tmpLahir' => '', 'tglLahir' => '', 'jk' => '', 'kawin' => '', 'hp' => '', 'email' => '', 'alamat' => '', 'divisi' => '', 'jabatan' => '', 'statusKerja' => '', 'karier' => [], 'pendidikan' => [], 'dokumen' => [],
    ], $k->toArray());
    $statusChip = ['Tetap' => 'chip-teal', 'Kontrak' => 'chip-amber', 'Honorer' => 'chip-purple'];
    $seed = [
        'karier' => $emp['karier'] ?: [],
        'pendidikan' => $emp['pendidikan'] ?: [],
        'dokumen' => $emp['dokumen'] ?: [],
    ];
@endphp
<x-layouts.app :title="__('Detail Karyawan')">
    <x-sidebar />
    <x-content :boxed="false">
        <div id="kryDetail" data-nik="{{ $emp['nik'] }}" data-load-url="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan/data') }}" data-save-url="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan/data') }}" data-msg-saved="{{ __('Perubahan tersimpan.') }}" data-msg-err="{{ __('Gagal menyimpan.') }}" data-msg-required="{{ __('Nama, divisi, dan jabatan wajib diisi.') }}" data-empty="{{ __('Belum ada data') }}" data-ph-key="{{ __('Nama kolom') }}" data-ph-val="{{ __('Isi data') }}" data-del-col="{{ __('Hapus kolom') }}" data-del-row="{{ __('Hapus baris') }}" data-doc-status="{{ json_encode(['Aktif' => __('Aktif'), 'Akan Habis' => __('Akan Habis'), 'Menunggu' => __('Menunggu'), 'Kedaluwarsa' => __('Kedaluwarsa')], JSON_UNESCAPED_UNICODE) }}" data-status-kerja="{{ json_encode(['Tetap' => __('Tetap'), 'Kontrak' => __('Kontrak'), 'Honorer' => __('Honorer')], JSON_UNESCAPED_UNICODE) }}">
            <script type="application/json" id="krySeed">{!! json_encode($seed, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!}</script>
            <div class="kry-bar">
                <a class="btn2 sm" href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan') }}"><span class="material-symbols-outlined">arrow_back</span>{{ __('Daftar') }}</a>
                <span class="kry-name">{{ $emp['nama'] }}</span>
                <span class="kry-sub">NIK {{ $emp['nik'] }}</span>
                <span class="chip kry-chip {{ $statusChip[$emp['statusKerja']] ?? 'chip-purple' }}">{{ __($emp['statusKerja'] ?? '') }}</span>
                <span class="kry-spacer"></span>
                <span class="kry-msg"></span>
                <button type="button" class="btn2 sm kry-edit2"><span class="material-symbols-outlined">edit</span>{{ __('Edit') }}</button>
                <button type="button" class="btn1 sm kry-save" hidden><span class="material-symbols-outlined">save</span>{{ __('Simpan') }}</button>
                <button type="button" class="btn2 sm kry-cancel" hidden>{{ __('Batal') }}</button>
            </div>

            <div class="kry-tabs">
                <button type="button" class="kry-tab on" data-tab="pribadi">{{ __('Data Pribadi') }}</button>
                <button type="button" class="kry-tab" data-tab="karier">{{ __('Karier') }}</button>
                <button type="button" class="kry-tab" data-tab="pendidikan">{{ __('Pendidikan') }}</button>
                <button type="button" class="kry-tab" data-tab="dokumen">{{ __('Dokumen') }}</button>
            </div>

            <div class="kry-form">
                <section class="kry-sec" data-sec="pribadi">
                    <div class="kry-grid">
                        <label class="fld"><span>NIK</span><input type="text" data-f="nik" data-lock value="{{ $emp['nik'] }}" readonly></label>
                        <label class="fld"><span>{{ __('Nama Lengkap') }}</span><input type="text" data-f="nama" value="{{ $emp['nama'] }}" readonly></label>
                        <label class="fld"><span>{{ __('No. KTP') }}</span><input type="text" data-f="ktp" value="{{ $emp['ktp'] }}" readonly></label>
                        <label class="fld"><span>{{ __('Tempat Lahir') }}</span><input type="text" data-f="tmpLahir" value="{{ $emp['tmpLahir'] }}" readonly></label>
                        <label class="fld"><span>{{ __('Tanggal Lahir') }}</span><input type="text" data-f="tglLahir" value="{{ $emp['tglLahir'] }}" readonly></label>
                        <label class="fld"><span>{{ __('Jenis Kelamin') }}</span><input type="text" data-f="jk" value="{{ $emp['jk'] }}" readonly></label>
                        <label class="fld"><span>{{ __('Status Kawin') }}</span><input type="text" data-f="kawin" value="{{ $emp['kawin'] }}" readonly></label>
                        <label class="fld"><span>{{ __('No. HP') }}</span><input type="text" data-f="hp" value="{{ $emp['hp'] }}" readonly></label>
                        <label class="fld"><span>{{ __('Email') }}</span><input type="text" data-f="email" value="{{ $emp['email'] }}" readonly></label>
                        <label class="fld wide"><span>{{ __('Alamat') }}</span><input type="text" data-f="alamat" value="{{ $emp['alamat'] }}" readonly></label>
                        <div class="fld-add-wrap">
                            <button type="button" class="btn2 sm fld-add"><span class="material-symbols-outlined">add</span>{{ __('Tambah Kolom') }}</button>
                        </div>
                    </div>
                </section>

                <section class="kry-sec" data-sec="karier" hidden>
                    <div class="kry-scroll">
                        <table class="kry-tbl">
                            <thead>
                                <tr>
                                    <th>{{ __('Tanggal Masuk') }}</th>
                                    <th>{{ __('Status Kerja') }}</th>
                                    <th>{{ __('Divisi') }}</th>
                                    <th>{{ __('Jabatan') }}</th>
                                    <th>{{ __('Atasan Langsung') }}</th>
                                    <th>{{ __('Lokasi Kerja') }}</th>
                                    <th class="c-act"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="sec-add-wrap">
                        <button type="button" class="btn2 sm rec-add"><span class="material-symbols-outlined">add</span>{{ __('Tambah Karier') }}</button>
                    </div>
                </section>

                <section class="kry-sec" data-sec="pendidikan" hidden>
                    <div class="kry-scroll">
                        <table class="kry-tbl">
                            <thead>
                                <tr>
                                    <th>{{ __('Jenjang') }}</th>
                                    <th>{{ __('Institusi') }}</th>
                                    <th>{{ __('Jurusan') }}</th>
                                    <th>{{ __('Tahun Lulus') }}</th>
                                    <th class="c-act"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="sec-add-wrap">
                        <button type="button" class="btn2 sm rec-add"><span class="material-symbols-outlined">add</span>{{ __('Tambah Pendidikan') }}</button>
                    </div>
                </section>

                <section class="kry-sec" data-sec="dokumen" hidden>
                    <div class="kry-scroll">
                        <table class="kry-tbl">
                            <thead>
                                <tr>
                                    <th>{{ __('Dokumen') }}</th>
                                    <th>{{ __('Nomor') }}</th>
                                    <th>{{ __('Berlaku s/d') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="c-act"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="sec-add-wrap">
                        <button type="button" class="btn2 sm rec-add"><span class="material-symbols-outlined">add</span>{{ __('Tambah Dokumen') }}</button>
                    </div>
                </section>
            </div>
        </div>
    </x-content>
</x-layouts.app>
