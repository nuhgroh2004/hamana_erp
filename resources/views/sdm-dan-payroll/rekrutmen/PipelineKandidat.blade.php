<x-rekrutmen.layout :title="__('Pipeline Kandidat')" active="pipeline-kandidat">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Pipeline Kandidat') }}</div>
            <h1 class="rkm-title">{{ __('Pipeline Kandidat') }}</h1>
        </div>
        <div>
            <select id="rkmPipeFilter" class="rkm-btn">
                <option value="">{{ __('Semua Posisi') }}</option>
                @foreach ($jobs as $j)
                    <option value="{{ $j['posisi'] }}">{{ $j['posisi'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="rkm-kb">
        @foreach ($stages as $i => $s)
            @php
                $list = array_values(array_filter($candidates, fn ($c) => $c['st'] === $i));
            @endphp
            <div class="rkm-col">
                <h4>{{ __($s->name) }}<span>{{ count($list) }}</span></h4>
                <div class="rkm-cs">
                    @foreach ($list as $c)
                        <div class="rkm-kc"
                            data-job="{{ $c['job'] }}"
                            data-dr-name="{{ $c['n'] }}"
                            data-dr-job="{{ $c['job'] }}"
                            data-dr-st="{{ $c['st'] }}"
                            data-dr-edu="{{ $c['edu'] }}"
                            data-dr-exp="{{ $c['exp'] }}"
                            data-dr-city="{{ $c['city'] }}"
                            data-dr-src="{{ $c['src'] }}"
                            data-dr-score="{{ $c['sc'] }}"
                            data-dr-note="{{ $c['note'] }}"
                            data-dr-log="{{ __('Melamar via') }} {{ $c['src'] }}"
                            data-dr-move="{{ $c['moveUrl'] }}"
                            data-dr-next="{{ $c['moveNext'] }}"
                            data-dr-reject="{{ $c['rejectUrl'] }}"
                            data-dr-reactivate="{{ $c['reactivateUrl'] }}"
                            data-dr-sched="{{ $c['schedUrl'] }}">
                            <b>{{ $c['n'] }}</b>
                            <small>{{ $c['job'] }}</small>
                            <small>{{ $c['exp'] }} thn · {{ $c['city'] }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-rekrutmen.layout>
