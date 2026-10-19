@props(['title' => 'Rekrutmen', 'active' => 'dashboard'])

<x-layouts.app :title="$title">
    <x-sidebar />
    <x-content :boxed="false">
        @php
            $rkmMenus = [
                ['key' => 'dashboard', 'url' => 'sdm-dan-payroll/rekrutmen', 'icon' => 'dashboard', 'label' => __('Dashboard')],
                ['key' => 'permintaan-tenaga-kerja', 'url' => 'sdm-dan-payroll/rekrutmen/permintaan-tenaga-kerja', 'icon' => 'assignment', 'label' => __('Permintaan Tenaga Kerja')],
                ['key' => 'lowongan', 'url' => 'sdm-dan-payroll/rekrutmen/lowongan', 'icon' => 'work', 'label' => __('Lowongan')],
                ['key' => 'pipeline-kandidat', 'url' => 'sdm-dan-payroll/rekrutmen/pipeline-kandidat', 'icon' => 'account_tree', 'label' => __('Pipeline Kandidat')],
                ['key' => 'daftar-kandidat', 'url' => 'sdm-dan-payroll/rekrutmen/daftar-kandidat', 'icon' => 'people', 'label' => __('Daftar Kandidat')],
                ['key' => 'jadwal-interview', 'url' => 'sdm-dan-payroll/rekrutmen/jadwal-interview', 'icon' => 'event', 'label' => __('Jadwal Interview')],
                ['key' => 'penawaran-kerja', 'url' => 'sdm-dan-payroll/rekrutmen/penawaran-kerja', 'icon' => 'description', 'label' => __('Penawaran Kerja')],
                ['key' => 'talent-pool', 'url' => 'sdm-dan-payroll/rekrutmen/talent-pool', 'icon' => 'pool', 'label' => __('Talent Pool')],
                ['key' => 'onboarding', 'url' => 'sdm-dan-payroll/rekrutmen/onboarding', 'icon' => 'how_to_reg', 'label' => __('Onboarding')],
                ['key' => 'laporan', 'url' => 'sdm-dan-payroll/rekrutmen/laporan', 'icon' => 'assessment', 'label' => __('Laporan')],
            ];
        @endphp
        <div class="rkm" id="rkm">
            <div class="rkm-sub" id="rkmSub">
                <div class="rkm-sub-head">
                    <b>{{ __('Rekrutmen') }}</b>
                    <button type="button" id="rkmHide" title="{{ __('Sembunyikan menu') }}"><span class="material-symbols-outlined">chevron_left</span></button>
                </div>
                <ul class="rkm-menu">
                    @foreach ($rkmMenus as $m)
                        <li>
                            <a href="{{ LaravelLocalization::localizeURL($m['url']) }}" class="{{ $active === $m['key'] ? 'on' : '' }}">
                                <span class="material-symbols-outlined rkm-icon">{{ $m['icon'] }}</span>{{ $m['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="rkm-main">
                <button type="button" class="rkm-show" id="rkmShow"><span class="material-symbols-outlined">menu</span>{{ __('Menu Rekrutmen') }}</button>
                {{ $slot }}
            </div>
        </div>
    </x-content>
</x-layouts.app>
