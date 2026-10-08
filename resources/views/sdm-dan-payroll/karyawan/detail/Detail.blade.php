@php
    $emp = \App\Support\KaryawanData::find(request('nik')) ?? \App\Support\KaryawanData::all()[0];
    $statusChip = ['Tetap' => 'chip-teal', 'Kontrak' => 'chip-amber', 'Honorer' => 'chip-purple'];
    $seed = [
        'karier' => $emp['karier'] ?? [],
        'pendidikan' => $emp['pendidikan'] ?? [],
        'dokumen' => $emp['dokumen'] ?? [],
    ];
@endphp
<x-layouts.app :title="'Detail Karyawan'">
    <x-sidebar />
    <x-content :boxed="false">
        <div id="kryDetail" data-nik="{{ $emp['nik'] }}">
            <script type="application/json" id="krySeed">{!! json_encode($seed, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!}</script>
            <div class="kry-bar">
                <a class="btn2 sm" href="{{ url('sdm-dan-payroll/karyawan') }}"><span class="material-symbols-outlined">arrow_back</span>Daftar</a>
                <span class="kry-name">{{ $emp['nama'] }}</span>
                <span class="kry-sub">NIK {{ $emp['nik'] }}</span>
                <span class="chip kry-chip {{ $statusChip[$emp['statusKerja']] ?? 'chip-purple' }}">{{ $emp['statusKerja'] }}</span>
                <span class="kry-spacer"></span>
                <span class="kry-msg"></span>
                <button type="button" class="btn2 sm kry-edit2"><span class="material-symbols-outlined">edit</span>Edit</button>
                <button type="button" class="btn1 sm kry-save" hidden><span class="material-symbols-outlined">save</span>Simpan</button>
                <button type="button" class="btn2 sm kry-cancel" hidden>Batal</button>
            </div>

            <div class="kry-tabs">
                <button type="button" class="kry-tab on" data-tab="pribadi">Data Pribadi</button>
                <button type="button" class="kry-tab" data-tab="karier">Karier</button>
                <button type="button" class="kry-tab" data-tab="pendidikan">Pendidikan</button>
                <button type="button" class="kry-tab" data-tab="dokumen">Dokumen</button>
            </div>

            <div class="kry-form">
                <section class="kry-sec" data-sec="pribadi">
                    <div class="kry-grid">
                        <label class="fld"><span>NIK</span><input type="text" data-f="nik" data-lock value="{{ $emp['nik'] }}" readonly></label>
                        <label class="fld"><span>Nama Lengkap</span><input type="text" data-f="nama" value="{{ $emp['nama'] }}" readonly></label>
                        <label class="fld"><span>No. KTP</span><input type="text" data-f="ktp" value="{{ $emp['ktp'] }}" readonly></label>
                        <label class="fld"><span>Tempat Lahir</span><input type="text" data-f="tmpLahir" value="{{ $emp['tmpLahir'] }}" readonly></label>
                        <label class="fld"><span>Tanggal Lahir</span><input type="text" data-f="tglLahir" value="{{ $emp['tglLahir'] }}" readonly></label>
                        <label class="fld"><span>Jenis Kelamin</span><input type="text" data-f="jk" value="{{ $emp['jk'] }}" readonly></label>
                        <label class="fld"><span>Status Kawin</span><input type="text" data-f="kawin" value="{{ $emp['kawin'] }}" readonly></label>
                        <label class="fld"><span>No. HP</span><input type="text" data-f="hp" value="{{ $emp['hp'] }}" readonly></label>
                        <label class="fld"><span>Email</span><input type="text" data-f="email" value="{{ $emp['email'] }}" readonly></label>
                        <label class="fld wide"><span>Alamat</span><input type="text" data-f="alamat" value="{{ $emp['alamat'] }}" readonly></label>
                        <div class="fld-add-wrap">
                            <button type="button" class="btn2 sm fld-add"><span class="material-symbols-outlined">add</span>Tambah Kolom</button>
                        </div>
                    </div>
                </section>

                <section class="kry-sec" data-sec="karier" hidden>
                    <div class="kry-scroll">
                        <table class="kry-tbl">
                            <thead>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th>Status Kerja</th>
                                    <th>Divisi</th>
                                    <th>Jabatan</th>
                                    <th>Atasan Langsung</th>
                                    <th>Lokasi Kerja</th>
                                    <th class="c-act"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="sec-add-wrap">
                        <button type="button" class="btn2 sm rec-add"><span class="material-symbols-outlined">add</span>Tambah Karier</button>
                    </div>
                </section>

                <section class="kry-sec" data-sec="pendidikan" hidden>
                    <div class="kry-scroll">
                        <table class="kry-tbl">
                            <thead>
                                <tr>
                                    <th>Jenjang</th>
                                    <th>Institusi</th>
                                    <th>Jurusan</th>
                                    <th>Tahun Lulus</th>
                                    <th class="c-act"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="sec-add-wrap">
                        <button type="button" class="btn2 sm rec-add"><span class="material-symbols-outlined">add</span>Tambah Pendidikan</button>
                    </div>
                </section>

                <section class="kry-sec" data-sec="dokumen" hidden>
                    <div class="kry-scroll">
                        <table class="kry-tbl">
                            <thead>
                                <tr>
                                    <th>Dokumen</th>
                                    <th>Nomor</th>
                                    <th>Berlaku s/d</th>
                                    <th>Status</th>
                                    <th class="c-act"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="sec-add-wrap">
                        <button type="button" class="btn2 sm rec-add"><span class="material-symbols-outlined">add</span>Tambah Dokumen</button>
                    </div>
                </section>
            </div>
        </div>
    </x-content>
</x-layouts.app>
