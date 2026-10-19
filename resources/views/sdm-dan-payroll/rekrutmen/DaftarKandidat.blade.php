<x-rekrutmen.layout :title="__('Daftar Kandidat')" active="daftar-kandidat">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Daftar Kandidat') }}</div>
            <h1 class="rkm-title">{{ __('Daftar Kandidat') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" data-rkm-form="rkmFormKandidat">+ {{ __('Tambah Kandidat') }}</button>
        </div>
    </div>

    <div class="rkm-bar">
        <input id="rkmCandQ" type="search" placeholder="{{ __('Cari nama / kota…') }}">
        <select id="rkmCandJob">
            <option value="">{{ __('Semua Posisi') }}</option>
            @foreach ($jobs as $j)
                <option value="{{ $j['posisi'] }}">{{ $j['posisi'] }}</option>
            @endforeach
        </select>
        <select id="rkmCandStage">
            <option value="">{{ __('Semua Tahap') }}</option>
            @foreach ($stages as $i => $s)
                <option value="{{ $i }}">{{ __($s) }}</option>
            @endforeach
            <option value="-1">{{ __('Ditolak') }}</option>
        </select>
    </div>

    <div class="rkm-tw" id="rkmCandTable">
        <table>
            <tr>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Posisi') }}</th>
                <th>{{ __('Pendidikan') }}</th>
                <th>{{ __('Pengalaman') }}</th>
                <th>{{ __('Sumber') }}</th>
                <th>{{ __('Skor Tes') }}</th>
                <th>{{ __('Tahap') }}</th>
            </tr>
            @forelse ($candidates as $c)
                <tr class="rkm-row"
                    data-job="{{ $c['job'] }}"
                    data-stage="{{ $c['st'] }}"
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
                    <td class="rkm-name"><b>{{ $c['n'] }}</b><br><small>{{ $c['city'] }}</small></td>
                    <td>{{ $c['job'] }}</td>
                    <td>{{ $c['edu'] }}</td>
                    <td>{{ $c['exp'] }} thn</td>
                    <td>{{ $c['src'] }}</td>
                    <td>{{ $c['sc'] ?: '—' }}</td>
                    <td>{!! $rkmStageTag($c['st']) !!}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="rkm-empty">{{ __('Tidak ada kandidat.') }}</td></tr>
            @endforelse
        </table>
    </div>

    <div class="rkm-empty" id="rkmCandEmpty" style="display:none">{{ __('Tidak ada kandidat.') }}</div>

    <template id="rkmFormKandidat">
        <form class="rkm-fm" data-url="{{ route('rekrutmen.kandidat.store') }}">
            <div class="rkm-dh">
                <div><b>{{ __('Tambah Kandidat') }}</b><small>{{ __('Kandidat baru masuk tahap Baru') }}</small></div>
                <button type="button" data-rkm-close>&times;</button>
            </div>
            <div class="rkm-fb">
                <label>{{ __('Nama Lengkap') }}
                    <input type="text" name="name" required>
                </label>
                <label>{{ __('Email') }}
                    <input type="email" name="email" required>
                </label>
                <label>{{ __('No. Telepon') }}
                    <input type="text" name="phone" placeholder="08…">
                </label>
                <label>{{ __('Posisi Dilamar') }}
                    <select name="job_posting_id" required>
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($jobs as $j)
                            @if ($j['statusRaw'] === 'active')
                                <option value="{{ $j['id'] }}">{{ $j['posisi'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </label>
                <label>{{ __('Kota') }}
                    <input type="text" name="city">
                </label>
                <label>{{ __('Pendidikan') }}
                    <input type="text" name="education" placeholder="mis. SMK Las">
                </label>
                <label>{{ __('Pengalaman (tahun)') }}
                    <input type="number" name="experience_years" min="0" max="50" value="0">
                </label>
                <label>{{ __('Sumber Lamaran') }}
                    <select name="source_id">
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($sources as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>{{ __('Skor Tes Teknis (0–100, opsional)') }}
                    <input type="number" name="score" min="0" max="100" placeholder="—">
                </label>
                <label>{{ __('Catatan') }}
                    <textarea name="notes" rows="2"></textarea>
                </label>
                <div class="rkm-act">
                    <button type="submit" class="rkm-btn p">{{ __('Simpan') }}</button>
                </div>
            </div>
        </form>
    </template>
</x-rekrutmen.layout>
