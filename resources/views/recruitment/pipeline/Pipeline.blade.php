<x-layouts.app :title="__('Pipeline Rekrutmen')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <div class="rc-card-title">{{ __('Pipeline Rekrutmen') }}</div>
                    <form method="GET" class="rc-filter">
                        <select name="job_posting_id" aria-label="{{ __('Posisi') }}">
                            <option value="">{{ __('Semua Posisi') }}</option>
                            @foreach ($jobPostings as $jp)
                                <option value="{{ $jp->id }}"{{ (string) $jobPostingId === (string) $jp->id ? ' selected' : '' }}>{{ $jp->title }}</option>
                            @endforeach
                        </select>
                        <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                    </form>
                </div>
                @if ($errors->any())
                    <div class="rc-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="rc-kanban">
                    @foreach ($stages as $stage)
                        @php $cards = $applications->get($stage->id, collect()); @endphp
                        <div class="rc-col">
                            <div class="rc-col-title">
                                <b>{{ $stage->name }}</b>
                                <span class="rc-col-count">{{ $cards->count() }}</span>
                            </div>
                            @forelse ($cards as $app)
                                <div class="rc-card-item">
                                    <a class="rc-item-title" href="{{ route('recruitment.candidates.show', $app->candidate) }}">{{ $app->candidate?->name }}</a>
                                    <div class="rc-card-sub">{{ $app->jobPosting?->title }}</div>
                                    <div class="rc-item-acts">
                                        <form method="POST" action="{{ route('recruitment.pipeline.move', $app) }}">
                                            @csrf
                                            <select name="stage_id" aria-label="{{ __('Pindah tahap') }}">
                                                @foreach ($stages as $s)
                                                    <option value="{{ $s->id }}"{{ $s->id === $app->current_stage_id ? ' disabled' : '' }}>{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn2 sm" type="submit" title="{{ __('Pindah tahap') }}"><span class="material-symbols-outlined">swap_horiz</span></button>
                                        </form>
                                        <details class="rc-details">
                                            <summary class="btn2 sm">{{ __('Tolak') }}</summary>
                                            <form method="POST" class="rc-reject-form" action="{{ route('recruitment.pipeline.reject', $app) }}">
                                                @csrf
                                                <select name="reason_id" required aria-label="{{ __('Alasan') }}">
                                                    <option value="">{{ __('Pilih alasan') }}</option>
                                                    @foreach ($rejectionReasons as $r)
                                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="notes" maxlength="1000" placeholder="{{ __('Catatan (opsional)') }}">
                                                <button class="btn2 sm" type="submit" data-confirm="{{ __('Tolak lamaran ini?') }}">{{ __('Tolak') }}</button>
                                            </form>
                                        </details>
                                    </div>
                                </div>
                            @empty
                                <div class="rc-card-sub">{{ __('Kosong') }}</div>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
