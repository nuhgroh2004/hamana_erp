<x-layouts.app :title="__('Laporan Rekrutmen')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            <div class="rc-grid3">
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Rata-rata Time-to-Hire') }}</div>
                    <div class="rc-kpi">{{ $avgTimeToHire !== null ? $avgTimeToHire.' '.__('hari') : '—' }}</div>
                    <div class="rc-sub">{{ __('Dari lamaran ke Hired (12 bulan)') }}</div>
                </div>
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Offer Acceptance Rate') }}</div>
                    <div class="rc-kpi">{{ $acceptanceRate }}%</div>
                    <div class="rc-sub">{{ $offerAccepted }} / {{ $offerTotal }} {{ __('penawaran diterima') }}</div>
                </div>
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Hired Bulan Ini') }}</div>
                    <div class="rc-kpi">{{ $hiredThisMonth }}</div>
                    <div class="rc-sub">{{ __('Karyawan diterima bulan berjalan') }}</div>
                </div>
            </div>

            <div class="rc-grid3">
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Kandidat per Sumber') }}</div>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>{{ __('Sumber') }}</th><th>{{ __('Jumlah') }}</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($bySource as $name => $total)
                                <tr><td>{{ $name }}</td><td>{{ $total }}</td></tr>
                            @empty
                                <tr><td colspan="2">{{ __('Belum ada data') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Pelamar per Tahap (aktif)') }}</div>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>{{ __('Tahap') }}</th><th>{{ __('Jumlah') }}</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($byStage as $name => $total)
                                <tr><td>{{ $name }}</td><td>{{ $total }}</td></tr>
                            @empty
                                <tr><td colspan="2">{{ __('Belum ada data') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Catatan') }}</div>
                    <div class="rc-sub">{{ __('Cost-per-hire tersedia setelah data biaya rekrutmen diintegrasikan.') }}</div>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
