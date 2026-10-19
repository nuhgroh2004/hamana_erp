<x-rekrutmen.layout :title="__('Rekrutmen')" active="dashboard">
    @php extract($rkm); @endphp

    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Dashboard') }}</div>
            <h1 class="rkm-title">{{ __('Dashboard Rekrutmen') }}</h1>
        </div>
        <div>
            <a class="rkm-btn p" href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/rekrutmen/lowongan') }}">+ {{ __('Lowongan Baru') }}</a>
        </div>
    </div>

    <div class="rkm-kpis">
        <div class="rkm-kpi"><small>{{ __('Lowongan Aktif') }}</small><b>{{ $stats['lowonganAktif'] }}</b></div>
        <div class="rkm-kpi"><small>{{ __('Total Kandidat') }}</small><b>{{ $stats['kandidat'] }}</b></div>
        <div class="rkm-kpi"><small>{{ __('Interview Minggu Ini') }}</small><b>{{ $stats['interviewMinggu'] }}</b></div>
        <div class="rkm-kpi"><small>{{ __('Offer Pending') }}</small><b>{{ $stats['offerPending'] }}</b></div>
        <div class="rkm-kpi"><small>{{ __('Hired Bulan Ini') }}</small><b>{{ $stats['hiredBulan'] }}</b></div>
        <div class="rkm-kpi"><small>{{ __('Rata² Time-to-Hire') }}</small><b>{{ $stats['tth'] }}</b></div>
    </div>

    <div class="rkm-grid2">
        <div class="rkm-card">
            <h3>{{ __('Funnel Rekrutmen') }}</h3>
            @foreach ($funnel as $f)
                <div class="rkm-fr">
                    <em>{{ __($f['label']) }}</em>
                    <div class="rkm-prog"><i style="width: {{ $funnelMax ? round($f['n'] / $funnelMax * 100) : 0 }}%"></i></div>
                    <b>{{ $f['n'] }}</b>
                </div>
            @endforeach
        </div>

        <div class="rkm-card">
            <h3>{{ __('Lowongan Prioritas Tinggi') }}</h3>
            @php $priorityShown = false; @endphp
            @foreach ($jobs as $j)
                @if ($j['prioritas'] === 'Tinggi')
                    @php $priorityShown = true; @endphp
                    <div class="rkm-fr wide">
                        <em>{{ $j['posisi'] }}</em>
                        <div class="rkm-prog"><i style="width: {{ $j['kuota'] ? min(100, round($j['hired'] / $j['kuota'] * 100)) : 0 }}%"></i></div>
                        <b>{{ $j['hired'] }}/{{ $j['kuota'] }}</b>
                    </div>
                @endif
            @endforeach
            @unless ($priorityShown)
                <div class="rkm-empty">{{ __('Tidak ada lowongan prioritas tinggi.') }}</div>
            @endunless
        </div>
    </div>

    <div class="rkm-card">
        <h3>{{ __('Aktivitas Terbaru') }}</h3>
        <div class="rkm-tl">
            @forelse ($aktivitas as $a)
                <div>{{ $a[0] }}<br><small>{{ $a[1] }}</small></div>
            @empty
                <div>{{ __('Belum ada aktivitas.') }}</div>
            @endforelse
        </div>
    </div>
</x-rekrutmen.layout>
