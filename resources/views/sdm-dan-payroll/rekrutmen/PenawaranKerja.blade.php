<x-rekrutmen.layout :title="__('Penawaran Kerja')" active="penawaran-kerja">
    @php
        $rupiah = fn ($v) => $v === null ? '—' : 'Rp ' . number_format($v / 1000000, 1, ',', '.') . ' jt';
    @endphp

    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Penawaran Kerja') }}</div>
            <h1 class="rkm-title">{{ __('Penawaran Kerja') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" data-rkm-form="rkmFormPenawaran">+ {{ __('Buat Penawaran') }}</button>
        </div>
    </div>

    <div class="rkm-tw">
        <table>
            <tr>
                <th>{{ __('Kandidat') }}</th>
                <th>{{ __('Posisi') }}</th>
                <th>{{ __('Gaji Pokok') }}</th>
                <th>{{ __('Tunjangan') }}</th>
                <th>{{ __('Mulai Kerja') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
            </tr>
            @forelse ($rows as $r)
                <tr class="rkm-row"
                    data-dr-name="{{ $r['n'] }}"
                    data-dr-job="{{ $r['job'] }}"
                    data-dr-st="{{ $r['st'] }}"
                    data-dr-edu="{{ $r['edu'] }}"
                    data-dr-exp="{{ $r['exp'] }}"
                    data-dr-city="{{ $r['city'] }}"
                    data-dr-src="{{ $r['src'] }}"
                    data-dr-score="0"
                    data-dr-note="{{ $r['note'] }}"
                    data-dr-log="{{ __('Penawaran kerja') }} {{ __($r['status']) }}"
                    data-dr-send="{{ $r['sendUrl'] }}"
                    data-dr-accept="{{ $r['acceptUrl'] }}"
                    data-dr-decline="{{ $r['declineUrl'] }}">
                    <td><b>{{ $r['n'] }}</b></td>
                    <td>{{ $r['job'] }}</td>
                    <td class="rkm-money">{{ $rupiah($r['gaji']) }}</td>
                    <td class="rkm-money">{{ $rupiah($r['tunjangan']) }}</td>
                    <td>{{ $r['mulai'] }}</td>
                    <td><span class="rkm-tag {{ $r['statusCls'] }}">{{ __($r['status']) }}</span></td>
                    <td class="rkm-rowact">
                        @if ($r['sendUrl'])
                            <button type="button" class="rkm-btn mini p" data-rkm-act
                                data-url="{{ $r['sendUrl'] }}">{{ __('Setujui & Kirim') }}</button>
                        @elseif ($r['acceptUrl'])
                            <button type="button" class="rkm-btn mini p" data-rkm-act
                                data-url="{{ $r['acceptUrl'] }}">{{ __('Diterima') }}</button>
                            <button type="button" class="rkm-btn mini d" data-rkm-act
                                data-confirm="{{ __('Tandai penawaran ditolak kandidat?') }}"
                                data-url="{{ $r['declineUrl'] }}">{{ __('Ditolak') }}</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="rkm-empty">{{ __('Belum ada penawaran.') }}</td></tr>
            @endforelse
        </table>
    </div>

    <template id="rkmFormPenawaran">
        <form class="rkm-fm" data-url="{{ route('rekrutmen.penawaran.store') }}">
            <div class="rkm-dh">
                <div><b>{{ __('Buat Penawaran Kerja') }}</b><small>{{ __('Kandidat tahap Interview User / Offering') }}</small></div>
                <button type="button" data-rkm-close>&times;</button>
            </div>
            <div class="rkm-fb">
                <label>{{ __('Kandidat') }}
                    <select name="application_id" required>
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($cands as $c)
                            <option value="{{ $c['app'] }}">{{ $c['n'] }} — {{ $c['job'] }}</option>
                        @endforeach
                    </select>
                </label>
                <label>{{ __('Gaji Pokok (Rp)') }}
                    <input type="number" name="base_salary" min="0" step="10000" required placeholder="mis. 4500000">
                </label>
                <label>{{ __('Tunjangan (Rp)') }}
                    <input type="number" name="allowance" min="0" step="10000" value="0">
                </label>
                <label>{{ __('Mulai Kerja') }}
                    <input type="date" name="start_date" required>
                </label>
                <label>{{ __('Berlaku Sampai') }}
                    <input type="date" name="valid_until">
                </label>
                <div class="rkm-act">
                    <button type="submit" class="rkm-btn p">{{ __('Simpan') }}</button>
                </div>
            </div>
        </form>
    </template>
</x-rekrutmen.layout>
