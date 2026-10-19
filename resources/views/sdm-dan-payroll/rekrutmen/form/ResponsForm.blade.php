<x-rekrutmen.layout :title="__('Respons Form')" active="form-rekrutmen">
    @php
        $open = $form->isOpen();
        $stateTag = ! $form->is_active
            ? '<span class="rkm-tag r">' . __('Nonaktif') . '</span>'
            : ($open ? '<span class="rkm-tag g">' . __('Aktif') . '</span>' : '<span class="rkm-tag y">' . __('Ditutup') . '</span>');
        $nResp = count($responses);
    @endphp

    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Form Rekrutmen') }} / {{ __('Editor') }}</div>
            <h1 class="rkm-title">{{ $form->title }}{!! $stateTag !!}</h1>
        </div>
        <div class="rf-hd-act">
            <button type="button" class="rf-sw {{ $form->is_active ? 'on' : '' }}" data-rf-toggle="{{ route('rekrutmen.form.toggle', $form) }}"><i></i>{{ $form->is_active ? __('Aktif') : __('Nonaktif') }}</button>
        </div>
    </div>

    <div class="rf-tabs">
        <a href="{{ route('rekrutmen.form.edit', $form) }}">{{ __('Edit') }}</a>
        <a href="{{ route('rekrutmen.form.preview', $form) }}">{{ __('Preview') }}</a>
        <a href="{{ route('rekrutmen.form.respons', $form) }}" class="on">{{ __('Respons') }} ({{ $nResp }})</a>
        <a href="{{ route('rekrutmen.form.bagikan', $form) }}">{{ __('Bagikan') }}</a>
    </div>

    <div class="rkm-top" style="margin-bottom:10px;align-items:center">
        <div><b>{{ $nResp }} {{ __('respons') }}</b></div>
        <div style="display:flex;gap:8px">
            <a href="{{ $exportUrl }}" class="rkm-btn">{{ __('Ekspor CSV') }}</a>
            <button type="button" class="rkm-btn d" id="rfrClear" data-url="{{ $clearUrl }}">{{ __('Hapus Semua') }}</button>
        </div>
    </div>

    @if ($summary && $responses)
        <div class="rkm-card">
            <h3>{{ __('Ringkasan') }}</h3>
            @foreach ($summary as $s)
                <b>{{ $s['label'] }}</b>
                @foreach ($s['options'] as $o)
                    @php
                        $total = count($responses);
                        $pct = $total ? round($o['count'] / $total * 100) : 0;
                    @endphp
                    <div class="rf-fr">
                        <em title="{{ $o['label'] }}">{{ $o['label'] }}</em>
                        <div class="rkm-prog"><i style="width: {{ $pct }}%"></i></div>
                        <b>{{ $o['count'] }}</b>
                    </div>
                @endforeach
                <br>
            @endforeach
        </div>
    @endif

    @if ($responses)
        <div class="rkm-tw">
            <table>
                <tr>
                    <th>{{ __('Waktu') }}</th>
                    @foreach ($fields as $f)
                        <th>{{ $f['label'] }}</th>
                    @endforeach
                    <th></th>
                </tr>
                @foreach ($responses as $r)
                    <tr data-rfr="{{ $r['id'] }}">
                        <td style="white-space:nowrap">{{ $r['waktu'] }}</td>
                        @foreach ($fields as $f)
                            @php
                                $v = $r['values'][$f['id']] ?? $r['values'][(string) $f['id']] ?? null;
                                $file = $r['files'][$f['id']] ?? $r['files'][(string) $f['id']] ?? null;
                            @endphp
                            <td>
                                @if ($f['type'] === 'file' && $file)
                                    <span class="rkm-tag b">📎 {{ $v }}</span>
                                @elseif (is_array($v))
                                    {{ $v ? implode(', ', $v) : '—' }}
                                @else
                                    <div class="rfr-cell" title="{{ $v }}">{{ $v ?: '—' }}</div>
                                @endif
                            </td>
                        @endforeach
                        <td class="rkm-rowact">
                            <button type="button" class="rkm-btn mini d" data-rfr-del="{{ route('rekrutmen.form.response.destroy', [$form, $r['id']]) }}">×</button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="rkm-card">
            <div class="rkm-empty">{{ __('Belum ada respons.') }}</div>
        </div>
    @endif
</x-rekrutmen.layout>
