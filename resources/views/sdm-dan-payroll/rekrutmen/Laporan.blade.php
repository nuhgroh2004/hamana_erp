<x-rekrutmen.layout :title="__('Laporan')" active="laporan">
    @php extract($rkm); @endphp

    @php
        $perSumber = [];
        foreach ($candidates as $c) {
            $src = $c['src'] !== '—' ? $c['src'] : __('Tidak diketahui');
            $perSumber[$src] = ($perSumber[$src] ?? 0) + 1;
        }
        arsort($perSumber);
        $maxSumber = $perSumber ? max($perSumber) : 0;

        $perTahap = [];
        foreach ($stages as $i => $s) {
            $perTahap[$s] = count(array_filter($candidates, fn ($c) => $c['st'] === $i));
        }
        $perTahap['Ditolak'] = count(array_filter($candidates, fn ($c) => $c['st'] < 0));
        $maxTahap = $perTahap ? max($perTahap) : 0;
    @endphp

    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Laporan') }}</div>
            <h1 class="rkm-title">{{ __('Laporan Rekrutmen') }}</h1>
        </div>
        <div></div>
    </div>

    <div class="rkm-grid2">
        <div class="rkm-card">
            <h3>{{ __('Kandidat per Sumber') }}</h3>
            @forelse ($perSumber as $src => $n)
                <div class="rkm-fr">
                    <em>{{ $src }}</em>
                    <div class="rkm-prog"><i style="width: {{ $maxSumber ? round($n / $maxSumber * 100) : 0 }}%"></i></div>
                    <b>{{ $n }}</b>
                </div>
            @empty
                <div class="rkm-empty">{{ __('Belum ada data.') }}</div>
            @endforelse
        </div>

        <div class="rkm-card">
            <h3>{{ __('Kandidat per Tahap') }}</h3>
            @forelse ($perTahap as $label => $n)
                <div class="rkm-fr">
                    <em>{{ __($label) }}</em>
                    <div class="rkm-prog"><i style="width: {{ $maxTahap ? round($n / $maxTahap * 100) : 0 }}%"></i></div>
                    <b>{{ $n }}</b>
                </div>
            @empty
                <div class="rkm-empty">{{ __('Belum ada data.') }}</div>
            @endforelse
        </div>
    </div>

    <div class="rkm-card">
        <h3>{{ __('Ringkasan') }}</h3>
        <div class="rkm-tw">
            <table>
                <tr>
                    <th>{{ __('Metrik') }}</th>
                    <th>{{ __('Nilai') }}</th>
                </tr>
                @foreach ($ringkasan as $r)
                    <tr>
                        <td>{{ $r[0] }}</td>
                        <td><b>{{ $r[1] }}</b></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-rekrutmen.layout>
