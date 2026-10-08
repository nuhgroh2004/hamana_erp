<x-layouts.app :title="'Karyawan'">
    <x-sidebar />
    <x-content :boxed="false">
        <div id="kry" data-detail="{{ url('sdm-dan-payroll/karyawan/detail') }}">
            <div class="kry-list" id="kryList">
                <div class="kry-bar">
                    <span class="kry-count" id="kryCount"></span>
                </div>
                <div class="kry-scroll">
                    <table class="kry-tbl">
                        <thead>
                            <tr>
                                <th class="c-sel"><input type="checkbox" id="kryAll" aria-label="Pilih semua karyawan"></th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Jabatan</th>
                                <th class="c-act">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Support\KaryawanData::all() as $k)
                                <tr data-id="{{ $k['nik'] }}" tabindex="0" title="Klik ganda untuk membuka detail">
                                    <td class="c-sel"><input type="checkbox" class="kry-chk" aria-label="Pilih {{ $k['nama'] }}"></td>
                                    <td>{{ $k['nik'] }}</td>
                                    <td class="c-nama">{{ $k['nama'] }}</td>
                                    <td class="c-divisi">{{ $k['divisi'] }}</td>
                                    <td class="c-jabatan">{{ $k['jabatan'] }}</td>
                                    <td class="c-act">
                                        <a class="btn2 sm" href="{{ url('sdm-dan-payroll/karyawan/detail') }}?nik={{ $k['nik'] }}"><span class="material-symbols-outlined">visibility</span>Detail</a>
                                        <a class="btn2 sm" href="{{ url('sdm-dan-payroll/karyawan/detail') }}?nik={{ $k['nik'] }}&amp;edit=1"><span class="material-symbols-outlined">edit</span>Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
