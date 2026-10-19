<x-rekrutmen.layout :title="__('Onboarding')" active="onboarding">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Onboarding') }}</div>
            <h1 class="rkm-title">{{ __('Onboarding Karyawan Baru') }}</h1>
        </div>
        <div></div>
    </div>

    @forelse ($cards as $card)
        <div class="rkm-card">
            <h3>{{ $card['n'] }} — {{ $card['job'] }}
                <small class="rkm-onb-meta">{{ __('Mulai') }}: {{ $card['start'] }} · {{ $card['done'] }}/{{ $card['total'] }} {{ __('selesai') }}</small>
            </h3>
            @forelse ($card['tasks'] as $task)
                <label class="rkm-ck {{ $task['done'] ? 'done' : '' }}">
                    <input type="checkbox" data-task="{{ $task['id'] }}"
                        data-url="{{ route('rekrutmen.onboarding.toggle', $task['id']) }}"
                        {{ $task['done'] ? 'checked' : '' }}>
                    <span>{{ __($task['title']) }}</span>
                </label>
            @empty
                <div class="rkm-empty">{{ __('Template onboarding kosong.') }}</div>
            @endforelse
        </div>
    @empty
        <div class="rkm-card rkm-empty">{{ __('Belum ada kandidat yang di-hired.') }}</div>
    @endforelse
</x-rekrutmen.layout>
