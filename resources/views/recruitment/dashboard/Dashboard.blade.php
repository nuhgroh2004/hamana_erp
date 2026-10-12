<x-layouts.app :title="__('Dashboard Rekrutmen')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            <div class="rc-kpis">
                <div class="rc-kpi"><span class="rc-kpi-num">{{ $kpis['active_postings'] }}</span><span class="rc-kpi-label">{{ __('Lowongan Aktif') }}</span></div>
                <div class="rc-kpi"><span class="rc-kpi-num">{{ $kpis['total_candidates'] }}</span><span class="rc-kpi-label">{{ __('Total Kandidat') }}</span></div>
                <div class="rc-kpi"><span class="rc-kpi-num">{{ $kpis['interviews_this_week'] }}</span><span class="rc-kpi-label">{{ __('Interview Minggu Ini') }}</span></div>
                <div class="rc-kpi"><span class="rc-kpi-num">{{ $kpis['pending_offers'] }}</span><span class="rc-kpi-label">{{ __('Penawaran Pending') }}</span></div>
                <div class="rc-kpi"><span class="rc-kpi-num">{{ $kpis['hired_this_month'] }}</span><span class="rc-kpi-label">{{ __('Diterima Bulan Ini') }}</span></div>
                <div class="rc-kpi"><span class="rc-kpi-num">{{ $kpis['avg_time_to_hire'] }}</span><span class="rc-kpi-label">{{ __('Rerata Time-to-Hire (hari)') }}</span></div>
            </div>
            <div class="rc-cols">
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Funnel Seleksi') }}</div>
                    <table class="rc-tbl">
                        <thead>
                            <tr>
                                <th>{{ __('Tahap') }}</th>
                                <th>{{ __('Jumlah Pelamar Aktif') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($funnel as $stage)
                                <tr>
                                    <td>{{ $stage->name }}</td>
                                    <td>{{ $stage->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('Belum ada tahapan.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Aktivitas Terbaru') }}</div>
                    <ul class="rc-acts">
                        @forelse ($activity as $log)
                            <li class="rc-act">
                                <span>{{ $log->changer?->name ?? __('Sistem') }} &mdash; {{ $log->application?->candidate?->name }}</span>
                                <span class="rc-act-time">{{ $log->fromStage?->name }} &rarr; {{ $log->toStage?->name }} &middot; {{ $log->created_at?->format('d/m/Y H:i') }}</span>
                            </li>
                        @empty
                            <li class="rc-act">{{ __('Belum ada aktivitas.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
