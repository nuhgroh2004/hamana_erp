<x-rekrutmen.layout :title="__('Talent Pool')" active="talent-pool">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Talent Pool') }}</div>
            <h1 class="rkm-title">{{ __('Talent Pool') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" data-rkm-form="rkmFormTalenta">+ {{ __('Tambah Talenta') }}</button>
        </div>
    </div>

    <div class="rkm-card">
        {{ __('Kandidat potensial yang belum dipekerjakan, bisa dihubungi kembali saat ada lowongan baru.') }}
    </div>

    <div class="rkm-tw">
        <table>
            <tr>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Keahlian / Posisi') }}</th>
                <th>{{ __('Skor') }}</th>
                <th>{{ __('Kota') }}</th>
                <th>{{ __('Catatan') }}</th>
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
                    data-dr-score="{{ $r['sc'] }}"
                    data-dr-note="{{ $r['note'] }}"
                    data-dr-log="{{ __('Masuk talent pool') }}">
                    <td><b>{{ $r['n'] }}</b></td>
                    <td>{{ $r['job'] }}</td>
                    <td>{{ $r['sc'] ?: '—' }}</td>
                    <td>{{ $r['city'] }}</td>
                    <td class="rkm-note">{{ $r['note'] ?: '—' }}</td>
                    <td class="rkm-rowact">
                        <button type="button" class="rkm-btn mini p" data-rkm-form="rkmFormPipeline"
                            data-cid="{{ $r['cid'] }}" data-cname="{{ $r['n'] }}">{{ __('Masuk Pipeline') }}</button>
                        <button type="button" class="rkm-btn mini d" data-rkm-act
                            data-confirm="{{ __('Keluarkan dari talent pool?') }}"
                            data-url="{{ route('rekrutmen.talent.remove', $r['cid']) }}">{{ __('Keluarkan') }}</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="rkm-empty">{{ __('Talent pool kosong.') }}</td></tr>
            @endforelse
        </table>
    </div>

    <template id="rkmFormTalenta">
        <form class="rkm-fm" data-url="{{ route('rekrutmen.talent.store') }}">
            <div class="rkm-dh">
                <div><b>{{ __('Tambah Talenta') }}</b><small>{{ __('Masuk talent pool, belum melamar') }}</small></div>
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
                <label>{{ __('Keahlian / Posisi') }}
                    <input type="text" name="skill" placeholder="mis. Teknisi Mesin">
                </label>
                <label>{{ __('Kota') }}
                    <input type="text" name="city">
                </label>
                <label>{{ __('Pendidikan') }}
                    <input type="text" name="education">
                </label>
                <label>{{ __('Pengalaman (tahun)') }}
                    <input type="number" name="experience_years" min="0" max="50" value="0">
                </label>
                <label>{{ __('Sumber') }}
                    <select name="source_id">
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($sources as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
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

    <template id="rkmFormPipeline">
        <form class="rkm-fm" data-url-base="{{ route('rekrutmen.talent.store') }}">
            <div class="rkm-dh">
                <div><b class="rkm-fm-name">{{ __('Masuk Pipeline') }}</b><small>{{ __('Pilih lowongan tujuan') }}</small></div>
                <button type="button" data-rkm-close>&times;</button>
            </div>
            <div class="rkm-fb">
                <label>{{ __('Lowongan') }}
                    <select name="job_posting_id" required>
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($jobs as $j)
                            <option value="{{ $j['id'] }}">{{ $j['posisi'] }}</option>
                        @endforeach
                    </select>
                </label>
                <div class="rkm-act">
                    <button type="submit" class="rkm-btn p">{{ __('Masukkan') }}</button>
                </div>
            </div>
        </form>
    </template>
</x-rekrutmen.layout>
