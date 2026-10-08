<x-layouts.app :title="__('Karyawan')">
    <x-sidebar />
    <x-content :boxed="false">
        <div id="kry" data-count="{{ __('{sel} dari {total} dipilih') }}" data-detail="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan/detail') }}">
            <div class="kry-list" id="kryList">
                <div class="kry-bar">
                    <span class="kry-count" id="kryCount"></span>
                </div>
                <div class="kry-scroll">
                    <table class="kry-tbl">
                        <thead>
                            <tr>
                                <th class="c-sel"><input type="checkbox" id="kryAll" aria-label="{{ __('Pilih semua karyawan') }}"></th>
                                <th>NIK</th>
                                <th>{{ __('Nama') }}</th>
                                <th>{{ __('Divisi') }}</th>
                                <th>{{ __('Jabatan') }}</th>
                                <th class="c-act">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Support\KaryawanData::all() as $k)
                                <tr data-id="{{ $k['nik'] }}" tabindex="0" title="{{ __('Klik ganda untuk membuka detail') }}">
                                    <td class="c-sel"><input type="checkbox" class="kry-chk" aria-label="{{ __('Pilih :nama', ['nama' => $k['nama']]) }}"></td>
                                    <td>{{ $k['nik'] }}</td>
                                    <td class="c-nama">{{ $k['nama'] }}</td>
                                    <td class="c-divisi">{{ $k['divisi'] }}</td>
                                    <td class="c-jabatan">{{ $k['jabatan'] }}</td>
                                    <td class="c-act">
                                        <a class="btn2 sm" href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan/detail') }}?nik={{ $k['nik'] }}"><span class="material-symbols-outlined">visibility</span>{{ __('Detail') }}</a>
                                        <a class="btn2 sm" href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan/detail') }}?nik={{ $k['nik'] }}&amp;edit=1"><span class="material-symbols-outlined">edit</span>{{ __('Edit') }}</a>
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
