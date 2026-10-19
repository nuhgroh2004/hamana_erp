<x-rekrutmen.layout :title="__('Jadwal Interview')" active="jadwal-interview">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Jadwal Interview') }}</div>
            <h1 class="rkm-title">{{ __('Jadwal Interview') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" data-rkm-form="rkmFormJadwal">+ {{ __('Jadwalkan') }}</button>
        </div>
    </div>

    <div class="rkm-tw">
        <table>
            <tr>
                <th>{{ __('Waktu') }}</th>
                <th>{{ __('Kandidat') }}</th>
                <th>{{ __('Posisi') }}</th>
                <th>{{ __('Jenis') }}</th>
                <th>{{ __('Pewawancara') }}</th>
                <th>{{ __('Tempat') }}</th>
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
                    data-dr-log="{{ __('Dijadwalkan') }} {{ __($r['jenis']) }}"
                    data-dr-cancel="{{ $r['cancelUrl'] }}">
                    <td class="rkm-time">{{ $r['waktu'] }}</td>
                    <td><b>{{ $r['n'] }}</b></td>
                    <td>{{ $r['job'] }}</td>
                    <td><span class="rkm-tag b">{{ __($r['jenis']) }}</span></td>
                    <td>{{ $r['pewawancara'] }}</td>
                    <td>{{ $r['tempat'] }}</td>
                    <td>
                        @if ($r['status'] === 'cancelled')
                            <span class="rkm-tag r">{{ __('Dibatalkan') }}</span>
                        @elseif ($r['status'] === 'done')
                            <span class="rkm-tag g">{{ __('Selesai') }}</span>
                        @else
                            <span class="rkm-tag y">{{ __('Terjadwal') }}</span>
                        @endif
                    </td>
                    <td class="rkm-rowact">
                        @if ($r['cancelUrl'])
                            <button type="button" class="rkm-btn mini d" data-rkm-act
                                data-confirm="{{ __('Batalkan jadwal interview ini?') }}"
                                data-url="{{ $r['cancelUrl'] }}">{{ __('Batalkan') }}</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="rkm-empty">{{ __('Belum ada jadwal interview.') }}</td></tr>
            @endforelse
        </table>
    </div>

    <template id="rkmFormJadwal">
        <form class="rkm-fm" data-url="{{ route('rekrutmen.jadwal.store') }}">
            <div class="rkm-dh">
                <div><b>{{ __('Jadwalkan Interview') }}</b><small>{{ __('Interview Kandidat') }}</small></div>
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
                <label>{{ __('Jenis') }}
                    <select name="type" required>
                        <option value="tes_praktik">{{ __('Tes Praktik') }}</option>
                        <option value="interview_hr">{{ __('Interview HR') }}</option>
                        <option value="interview_user">{{ __('Interview User') }}</option>
                    </select>
                </label>
                <label>{{ __('Tanggal') }}
                    <input type="date" name="date" min="{{ now()->toDateString() }}" required>
                </label>
                <label>{{ __('Jam') }}
                    <input type="time" name="time" value="09:00" required>
                </label>
                <label>{{ __('Durasi (menit)') }}
                    <input type="number" name="duration_minutes" min="15" max="480" value="60">
                </label>
                <label>{{ __('Tempat') }}
                    <input type="text" name="location" placeholder="mis. Ruang Meeting 1">
                </label>
                <label>{{ __('Pewawancara') }}
                    <input type="text" name="interviewer" placeholder="mis. Tim HRD">
                </label>
                <div class="rkm-act">
                    <button type="submit" class="rkm-btn p">{{ __('Simpan') }}</button>
                </div>
            </div>
        </form>
    </template>
</x-rekrutmen.layout>
