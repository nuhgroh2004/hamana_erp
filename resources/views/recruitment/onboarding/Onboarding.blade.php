<x-layouts.app :title="__('Onboarding')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            @if (session('rc_errors'))
                <div class="rc-errors">
                    <ul>
                        <li>{{ session('rc_errors') }}</li>
                    </ul>
                </div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <div class="rc-card-title">{{ __('Onboarding Karyawan Baru') }}</div>
                    <form method="GET" class="rc-filter">
                        <select name="status" aria-label="{{ __('Status') }}">
                            <option value="">{{ __('Semua Status') }}</option>
                            <option value="ongoing"{{ $status === 'ongoing' ? ' selected' : '' }}>{{ __('Berjalan') }}</option>
                            <option value="done"{{ $status === 'done' ? ' selected' : '' }}>{{ __('Selesai') }}</option>
                        </select>
                        <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                    </form>
                </div>

                @forelse ($items as $o)
                    @php $done = $o->tasks->where('is_done', true)->count(); @endphp
                    <div class="rc-block">
                        <div class="rc-bar">
                            <div>
                                <strong>{{ $o->application?->candidate?->name }}</strong>
                                <span class="rc-sub">{{ $o->application?->jobPosting?->title }} &middot; NIK {{ $o->employee_id }} &middot; {{ __('Mulai') }}: {{ $o->start_date?->format('d/m/Y') }}</span>
                            </div>
                            <div class="rc-actions">
                                <span class="rc-chip {{ $o->status === 'done' ? 'rc-chip-teal' : 'rc-chip-amber' }}">{{ $o->status === 'done' ? __('Selesai') : __('Berjalan') }}</span>
                                @if ($o->status !== 'done')
                                    <form method="POST" action="{{ route('recruitment.onboarding.complete', $o) }}">
                                        @csrf
                                        <button class="btn2 sm" type="submit" data-confirm="{{ __('Tandai onboarding selesai?') }}"><span class="material-symbols-outlined">task_alt</span>{{ __('Selesaikan') }}</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="rc-prog" title="{{ $done }}/{{ $o->tasks->count() }}">
                            <span style="width: {{ $o->tasks->count() ? round($done / $o->tasks->count() * 100) : 0 }}%"></span>
                        </div>
                        <div class="rc-check-grid">
                            @forelse ($o->tasks as $task)
                                <form method="POST" class="rc-check-item{{ $task->is_done ? ' is-done' : '' }}" action="{{ route('recruitment.onboarding.tasks.toggle', $task) }}">
                                    @csrf
                                    <button type="submit" class="rc-check-btn" title="{{ __('Toggle') }}">
                                        <span class="material-symbols-outlined">{{ $task->is_done ? 'check_box' : 'check_box_outline_blank' }}</span>
                                        {{ $task->title }}
                                    </button>
                                    <span class="rc-sub">{{ $task->doer?->name }}{{ $task->done_at ? ' &middot; '.$task->done_at->format('d/m/Y') : '' }}</span>
                                </form>
                            @empty
                                <div class="rc-sub">{{ __('Belum ada data') }}</div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="rc-block">{{ __('Belum ada data') }}</div>
                @endforelse

                {{ $items->links() }}
            </div>
        </div>
    </x-content>
</x-layouts.app>
