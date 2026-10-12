<x-layouts.app :title="__('Lowongan')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <a class="btn1 sm" href="{{ route('recruitment.job-postings.create') }}"><span class="material-symbols-outlined">add</span>{{ __('Buat Lowongan') }}</a>
                    <form method="GET" class="rc-filter">
                        <label class="rc-filter-label" for="jpStatus">{{ __('Status') }}</label>
                        <select id="jpStatus" name="status">
                            <option value="">{{ __('Semua') }}</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s->value }}"{{ $status === $s->value ? ' selected' : '' }}>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                        <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                    </form>
                </div>
                <div class="rc-scroll">
                    <table class="rc-tbl">
                        <thead>
                            <tr>
                                <th>{{ __('Judul') }}</th>
                                <th>{{ __('MPP') }}</th>
                                <th>{{ __('Departemen') }}</th>
                                <th>{{ __('Lokasi') }}</th>
                                <th>{{ __('Progres Kuota') }}</th>
                                <th>{{ __('Pelamar') }}</th>
                                <th>{{ __('Batas daftar') }}</th>
                                <th>{{ __('Prioritas') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $jp)
                                @php
                                    $pct = $jp->quota > 0 ? min(100, (int) round($jp->hired_count * 100 / $jp->quota)) : 0;
                                    $priorityLabel = match ($jp->priority) {
                                        'high' => __('Tinggi'),
                                        'low' => __('Rendah'),
                                        default => __('Sedang'),
                                    };
                                    $priorityClass = match ($jp->priority) {
                                        'high' => 'rc-chip rc-chip-red',
                                        'low' => 'rc-chip rc-chip-teal',
                                        default => 'rc-chip rc-chip-amber',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $jp->title }}</td>
                                    <td>{{ $jp->jobRequest?->code }}</td>
                                    <td>{{ $jp->department?->name }}</td>
                                    <td>{{ $jp->location }}</td>
                                    <td>
                                        <span>{{ $jp->hired_count }} / {{ $jp->quota }}</span>
                                        <span class="rc-prog"><span class="rc-prog-bar" style="width: {{ $pct }}%"></span></span>
                                    </td>
                                    <td>{{ $jp->applications_count }}</td>
                                    <td>{{ $jp->deadline?->format('d/m/Y') }}</td>
                                    <td><span class="{{ $priorityClass }}">{{ $priorityLabel }}</span></td>
                                    <td><span class="{{ $jp->status->chipClass() }}">{{ $jp->status->label() }}</span></td>
                                    <td>
                                        <div class="rc-actions">
                                            <a class="btn2 sm" href="{{ route('recruitment.job-postings.edit', $jp) }}"><span class="material-symbols-outlined">edit</span>{{ __('Edit') }}</a>
                                            @if ($jp->status->value === 'draft')
                                                <form method="POST" class="rc-inline" action="{{ route('recruitment.job-postings.publish', $jp) }}" data-confirm="{{ __('Publikasikan lowongan :title?', ['title' => $jp->title]) }}">
                                                    @csrf
                                                    <button class="btn1 sm" type="submit">{{ __('Publikasikan') }}</button>
                                                </form>
                                            @endif
                                            @if ($jp->status->value === 'active')
                                                <form method="POST" class="rc-inline" action="{{ route('recruitment.job-postings.close', $jp) }}" data-confirm="{{ __('Tutup lowongan :title?', ['title' => $jp->title]) }}">
                                                    @csrf
                                                    <button class="btn2 sm" type="submit">{{ __('Tutup') }}</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">{{ __('Belum ada data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </x-content>
</x-layouts.app>
