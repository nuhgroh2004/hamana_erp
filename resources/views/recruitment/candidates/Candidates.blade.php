<x-layouts.app :title="__('Daftar Kandidat')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <a class="btn1 sm" href="{{ route('recruitment.candidates.create') }}"><span class="material-symbols-outlined">person_add</span>{{ __('Tambah Kandidat') }}</a>
                    <form method="GET" class="rc-filter">
                        <input type="search" name="q" value="{{ $q }}" placeholder="{{ __('Cari nama atau kota…') }}" aria-label="{{ __('Cari nama atau kota') }}">
                        <select name="job_posting_id" aria-label="{{ __('Posisi') }}">
                            <option value="">{{ __('Semua Posisi') }}</option>
                            @foreach ($jobPostings as $jp)
                                <option value="{{ $jp->id }}"{{ (string) $jobPostingId === (string) $jp->id ? ' selected' : '' }}>{{ $jp->title }}</option>
                            @endforeach
                        </select>
                        <select name="stage_id" aria-label="{{ __('Tahap') }}">
                            <option value="">{{ __('Semua Tahap') }}</option>
                            @foreach ($stages as $st)
                                <option value="{{ $st->id }}"{{ (string) $stageId === (string) $st->id ? ' selected' : '' }}>{{ $st->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                    </form>
                </div>
                <div class="rc-scroll">
                    <table class="rc-tbl">
                        <thead>
                            <tr>
                                <th>{{ __('Nama') }}</th>
                                <th>Email</th>
                                <th>{{ __('No. HP') }}</th>
                                <th>{{ __('Kota') }}</th>
                                <th>{{ __('Pendidikan') }}</th>
                                <th>{{ __('Pengalaman') }}</th>
                                <th>{{ __('Sumber') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $c)
                                <tr>
                                    <td>
                                        {{ $c->name }}
                                        @if ($c->is_talent_pool)
                                            <span class="rc-chip rc-chip-purple">★ {{ __('Talent Pool') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $c->email }}</td>
                                    <td>{{ $c->phone }}</td>
                                    <td>{{ $c->city }}</td>
                                    <td>{{ $c->education }}</td>
                                    <td>{{ $c->experience_years }} {{ __('tahun') }}</td>
                                    <td>{{ $c->source?->name }}</td>
                                    <td>
                                        <div class="rc-actions">
                                            <a class="btn2 sm" href="{{ route('recruitment.candidates.show', $c) }}"><span class="material-symbols-outlined">visibility</span>{{ __('Detail') }}</a>
                                            <a class="btn2 sm" href="{{ route('recruitment.candidates.edit', $c) }}"><span class="material-symbols-outlined">edit</span>{{ __('Edit') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">{{ __('Belum ada data') }}</td>
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
